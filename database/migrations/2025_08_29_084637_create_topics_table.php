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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('path_image')->nullable();
            $table->string('title')->nullable();
            $table->text('link')->nullable();
            $table->integer('sorting')->default(0);
            $table->boolean('active')->default(0);
            $table->enum('color', ['dark-background', 'background-red'])->default('dark-background');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
