<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            // Identificação do pedido
            $table->string('number', 30);

            // Dados do cliente no momento da compra
            $table->foreignId('client_id')
            ->constrained('clients')
            ->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone', 20);

            // Endereço de entrega
            $table->json('delivery_address')->nullable();

            // Status do pedido
            $table->string('status', 30)->default('pending');

            // Status do pagamento
            $table->string('payment_status', 30)->default('pending');

            // Valores do pedido
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Observações do cliente
            $table->text('notes')->nullable();

            // Data e hora da realização do pedido
            $table->timestamp('placed_at')->useCurrent();

            $table->timestamps();

            // Número único dentro de cada estabelecimento
            $table->unique(['tenant_id', 'number']);

            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'payment_status']);
            $table->index(['tenant_id', 'placed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};