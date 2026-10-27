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
        Schema::table('service_sections', function (Blueprint $table) {
            $table->enum('section', [
                'service',
                'gallery',
                'testimonial',
                'planNetwork',
                'product',
                'pilar',
                'advantages_persona',
                'advantages_enterprise',
                'partners',
                'banner_inner',
            ])->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_sections', function (Blueprint $table) {
            $table->enum('section', [
                'service',
                'gallery',
                'testimonial',
                'planNetwork',
                'product',
            ])->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }
};
