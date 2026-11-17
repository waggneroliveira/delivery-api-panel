<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Listar pedidos do tenant atual.
     */
    public function index(Request $request)
    {
        $tenant = Tenant::current();
        $client = $request->user();

        $orders = Order::query()
            ->where('tenant_id', $tenant->id)
            ->where('client_id', $client->id)
            ->with('items')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Registrar um novo pedido.
     */
    public function store(Request $request): JsonResponse
    {
        $client = $request->user();

        $validated = $request->validate([
            'delivery_address' => [
                'nullable',
                'array',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'delivery_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'items.*.price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'items.*.details' => [
                'nullable',
                'array',
            ],
        ]);

        $tenant = Tenant::current();

        $order = DB::transaction(function () use ($validated, $tenant, $client) {

            $subtotal = 0;

            $items = [];

            foreach ($validated['items'] as $item) {

                $product = Product::query()
                    ->where('tenant_id', $tenant->id)
                    ->where('active', true)
                    ->findOrFail($item['product_id']);

                $quantity = $item['quantity'];

                $unitPrice = $this->resolveUnitPrice($product, $item);

                $totalPrice = round($unitPrice * $quantity, 2);

                $subtotal += $totalPrice;

                $items[] = [
                    'product_id' => $product->id,

                    'product_title' => $product->title,
                    'product_slug' => $product->slug,
                    'product_image' => $product->path_image,
                    'product_type' => $product->product_type,

                    'quantity' => $quantity,

                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,

                    'details' => $item['details'] ?? null,
                ];
            }

            $deliveryFee = $validated['delivery_fee'] ?? 0;
            $discount = $validated['discount'] ?? 0;

            if ($discount > ($subtotal + $deliveryFee)) {
                throw ValidationException::withMessages([
                    'discount' => 'O desconto não pode ser maior que o valor do pedido.',
                ]);
            }

            $order = Order::create([
                'tenant_id' => $tenant->id,

                'number' => $this->generateOrderNumber($tenant->id),

                'client_id' => $client->id,
                'customer_name' => $client->name,
                'customer_phone' => $client->phone,

                'delivery_address' => $validated['delivery_address'] ?? null,

                'status' => 'pending',
                'payment_status' => 'pending',

                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'discount' => $discount,

                'total' => $subtotal + $deliveryFee - $discount,

                'notes' => $validated['notes'] ?? null,

                'placed_at' => now(),
            ]);

            $order->items()->createMany($items);

            return $order;
        });

        return response()->json([
            'message' => 'Pedido realizado com sucesso!',
            'data' => $order->load('items'),
        ], 201);
    }

    /**
     * Consultar detalhes de um pedido.
     */
    public function show(Request $request, int $id)
    {
        $tenant = Tenant::current();
        $client = $request->user();

        $order = Order::query()
            ->where('tenant_id', $tenant->id)
            ->where('client_id', $client->id)
            ->with('items')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Atualizar status do pedido.
     */
    public function updateStatus(
        Request $request,
        int $id
    ): JsonResponse {

        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,preparing,ready,out_for_delivery,delivered,canceled',
            ],
        ]);

        $tenant = Tenant::current();

        $order = Order::query()
            ->where('tenant_id', $tenant->id)
            ->findOrFail($id);

        $order->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Status do pedido atualizado com sucesso!',
            'data' => $order,
        ]);
    }

    private function resolveUnitPrice(Product $product, array $item): float
    {
        // The cart sends the finalized price with customizations; older clients send only product_id.
        $submittedPrice = $item['unit_price'] ?? $item['price'] ?? null;

        return round(
            $submittedPrice !== null ? (float) $submittedPrice : (float) $product->price,
            2
        );
    }

    /**
     * Gerar número único por tenant.
     */
    private function generateOrderNumber(int $tenantId): string
    {
        do {
            $number = 'PED-' . now()->format('ymd') . '-' . Str::upper(
                Str::random(6)
            );

        } while (
            Order::query()
                ->where('tenant_id', $tenantId)
                ->where('number', $number)
                ->exists()
        );

        return $number;
    }
}