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
        Schema::table('template_themes', function (Blueprint $table) {
            $table->string('text_button_one')->default('Saiba mais');
            $table->string('color_button_one')->default('#FFF');
            $table->string('bg_button_one')->default('#10131C');
            $table->string('text_button_two')->default('Ver mais');
            $table->string('color_button_two')->default('#000');
            $table->string('bg_button_two')->default('#FDC20C');
            $table->string('text_color_header')->default('#000');
            $table->string('bg_header')->default('#FFF');
            $table->string('bg_scroll')->default('#10131C');
            $table->string('copyright')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_themes', function (Blueprint $table) {
            //
        });
    }
};
