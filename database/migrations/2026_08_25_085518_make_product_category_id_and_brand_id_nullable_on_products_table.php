<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_category_id')
                ->nullable()
                ->change();

            $table->foreignId('brand_id')
                ->nullable()
                ->change();

            $table->text('description')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_category_id')
                ->nullable(false)
                ->change();

            $table->foreignId('brand_id')
                ->nullable(false)
                ->change();

            $table->text('description')
                ->nullable(false)
                ->change();
        });
    }
};
