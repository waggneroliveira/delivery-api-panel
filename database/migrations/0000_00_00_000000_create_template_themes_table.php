<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\LayoutType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('template_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('preview')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->string('template_variation')->default('default');
            $table->string('primary_color', 10)->default('#10131C');
            $table->string('secondary_color', 10)->default('#FF7A1D');
            $table->string('accent_color')->default('#10513D80');
            $table->string('text_color', 10)->default('#565656');
            $table->string('path_image_logo_header')->nullable();
            $table->string('path_image_logo_footer')->nullable();
            $table->enum( 'layout_type', array_column(LayoutType::cases(), 'value'))->default(LayoutType::OnePage->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_themes');
    }
};
