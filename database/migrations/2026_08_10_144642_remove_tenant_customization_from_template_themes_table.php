<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_themes', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color',
                'secondary_color',
                'accent_color',
                'text_color',
                'path_image_logo_header',
                'path_image_logo_footer',
                'text_button_one',
                'color_button_one',
                'bg_button_one',
                'text_button_two',
                'color_button_two',
                'bg_button_two',
                'text_color_header',
                'bg_header',
                'bg_scroll',
                'copyright',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('template_themes', function (Blueprint $table) {
            $table->string('primary_color', 10)->default('#10131C');
            $table->string('secondary_color', 10)->default('#FF7A1D');
            $table->string('accent_color')->default('#10513D80');
            $table->string('text_color', 10)->default('#565656');
            $table->string('path_image_logo_header')->nullable();
            $table->string('path_image_logo_footer')->nullable();

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
};