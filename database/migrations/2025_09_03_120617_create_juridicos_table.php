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
        Schema::create('juridicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->enum('legal', ['leis', 'decretos', 'portaria'])->nullable();
            $table->enum('region', ['nacional', 'municipal'])->nullable();
            $table->string('title')->nullable();
            $table->text('link')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->text('path_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juridicos');
    }
};
