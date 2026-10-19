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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('blog_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->date('date');
            $table->longText('text')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_thumbnail')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('super_highlight')->default(0);
            $table->boolean('highlight')->default(0);
            $table->integer('sorting')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
