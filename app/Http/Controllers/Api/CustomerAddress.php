<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CustomerAddress as CustomerAddressModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerAddress extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $client = $this->client($request);

        return response()->json([
            'data' => $client->addresses()
                ->orderByDesc('is_default')
                ->orderBy('id')
                ->get()
                ->map(fn (CustomerAddressModel $address) => $this->addressData($address)),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $client = $this->client($request);
        $data = $this->validatedAddress($request);

        return DB::transaction(function () use ($client, $data) {
            $client = Client::query()
                ->lockForUpdate()
                ->findOrFail($client->id);

            if ($client->addresses()->count() >= 2) {
                return response()->json([
                    'message' => 'O cliente pode cadastrar no máximo 2 endereços.',
                ], 422);
            }

            if ($data['is_default']) {
                $client->addresses()->update(['is_default' => false]);
            }

            $address = $client->addresses()->create($data);

            return response()->json([
                'message' => 'Endereço cadastrado com sucesso.',
                'data' => $this->addressData($address),
            ], 201);
        });
    }

    public function show(Request $request, int $address): JsonResponse
    {
        $customerAddress = $this->client($request)
            ->addresses()
            ->findOrFail($address);

        return response()->json([
            'data' => $this->addressData($customerAddress),
        ]);
    }

    public function update(Request $request, int $address): JsonResponse
    {
        $client = $this->client($request);
        $data = $this->validatedAddress($request, partial: true);

        if ($data === []) {
            return response()->json([
                'message' => 'Informe ao menos um dado para atualizar.',
            ], 422);
        }

        return DB::transaction(function () use ($client, $address, $data) {
            $client = Client::query()
                ->lockForUpdate()
                ->findOrFail($client->id);
            $customerAddress = $client->addresses()
                ->lockForUpdate()
                ->findOrFail($address);

            if ($data['is_default'] ?? false) {
                $client->addresses()
                    ->where('id', '!=', $customerAddress->id)
                    ->update(['is_default' => false]);
            }

            $customerAddress->update($data);

            return response()->json([
                'message' => 'Endereço atualizado com sucesso.',
                'data' => $this->addressData($customerAddress->refresh()),
            ]);
        });
    }

    public function destroy(Request $request, int $address): JsonResponse
    {
        $client = $this->client($request);

        return DB::transaction(function () use ($client, $address) {
            $client = Client::query()
                ->lockForUpdate()
                ->findOrFail($client->id);
            $customerAddress = $client->addresses()
                ->lockForUpdate()
                ->findOrFail($address);
            $customerAddress->delete();

            return response()->json([
                'message' => 'Endereço removido com sucesso.',
            ]);
        });
    }

    private function validatedAddress(Request $request, bool $partial = false): array
    {
        $required = $partial ? 'sometimes' : 'required';
        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'string', 'max:255'],
            'recipient_name' => [$required, 'string', 'max:255'],
            'zip_code' => [$required, 'string', 'max:9', 'regex:/^\d{5}-?\d{3}$/'],
            'state' => [$required, 'string', 'size:2'],
            'city' => [$required, 'string', 'max:255'],
            'neighborhood' => [$required, 'string', 'max:255'],
            'street' => [$required, 'string', 'max:255'],
            'number' => [$required, 'string', 'max:30'],
            'complement' => ['sometimes', 'nullable', 'string', 'max:255'],
            'reference' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            abort(response()->json([
                'message' => 'Os dados informados são inválidos.',
                'errors' => $validator->errors(),
            ], 422));
        }

        $data = $validator->validated();
        if (! $partial) {
            $data['title'] = $data['title'] ?? 'Casa';
            $data['is_default'] = filter_var(
                $data['is_default'] ?? false,
                FILTER_VALIDATE_BOOLEAN
            );
        } elseif (array_key_exists('is_default', $data)) {
            $data['is_default'] = filter_var($data['is_default'], FILTER_VALIDATE_BOOLEAN);
        }

        if (array_key_exists('state', $data)) {
            $data['state'] = strtoupper($data['state']);
        }

        return $data;
    }

    private function client(Request $request): Client
    {
        $client = $request->user();
        abort_unless($client instanceof Client, 401, 'Não autenticado.');

        return $client;
    }

    private function addressData(CustomerAddressModel $address): array
    {
        return $address->only([
            'id',
            'title',
            'recipient_name',
            'zip_code',
            'state',
            'city',
            'neighborhood',
            'street',
            'number',
            'complement',
            'reference',
            'is_default',
        ]);
    }
}
