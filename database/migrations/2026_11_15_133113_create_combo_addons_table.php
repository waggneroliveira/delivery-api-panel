
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combo_addons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('name');

            $table->decimal('price', 10, 2)->default(0);

            $table->unsignedSmallInteger('max_quantity')
                ->nullable();

            $table->boolean('active')->default(true);
            $table->unsignedInteger('sorting')->default(0);

            $table->timestamps();

            $table->index(['tenant_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combo_addons');
    }
};
