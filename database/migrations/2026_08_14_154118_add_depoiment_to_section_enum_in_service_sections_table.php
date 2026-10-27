<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_sections', function (Blueprint $table) {
            $table->enum('section', [
                'service',
                'gallery',
                'testimonial'
            ])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('service_sections', function (Blueprint $table) {
            $table->enum('section', [
                'service',
                'gallery'
            ])->nullable()->change();
        });
    }
};
