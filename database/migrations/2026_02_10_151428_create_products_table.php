<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')->constrained();

            $table->foreignId('product_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('name')->nullable();
            $table->string('function')->nullable();

            $table->string('title');
            $table->string('slug');

            $table->string('description');
            $table->longText('text')->nullable();

            $table->string('path_image')->nullable();
            $table->string('path_file')->nullable();

            $table->string('link')->nullable();
            $table->string('btn_title')->nullable();
            $table->enum('link_type', ['internal', 'external'])->default('internal');

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('cashback', 5, 2)->default(0);

            $table->string('product_type')->nullable();
            $table->string('cuisine_type')->nullable();

            $table->json('sizes')->nullable();
            $table->json('tags')->nullable();
            $table->json('specifications')->nullable();
            $table->json('stock')->nullable();

            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(false);

            $table->unsignedInteger('sorting')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
