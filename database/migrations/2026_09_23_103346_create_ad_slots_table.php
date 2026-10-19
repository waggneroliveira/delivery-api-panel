<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_theme_id')
                ->constrained('template_themes')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->enum('exhibition', [
                'horizontal',
                'vertical',
                'mobile',
            ]);

            $table->boolean('active')->default(true);
            $table->unsignedInteger('sorting')->default(0);

            $table->timestamps();

            $table->unique([
                'template_theme_id',
                'slug',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_slots');
    }
};