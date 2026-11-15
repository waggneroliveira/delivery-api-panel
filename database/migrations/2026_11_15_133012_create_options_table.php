
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('combo_item_id')
                ->nullable()
                ->constrained('combo_items')
                ->cascadeOnDelete();

            $table->string('type', 30);
            $table->string('title');

            $table->boolean('required')->default(false);

            $table->unsignedSmallInteger('max_selections')
                ->nullable();

            $table->json('choices');

            $table->boolean('active')->default(true);
            $table->unsignedInteger('sorting')->default(0);

            $table->timestamps();

            $table->index(['tenant_id', 'product_id']);
            $table->index(['tenant_id', 'combo_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
