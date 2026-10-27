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
        Schema::create('form_indices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('tenant_id')->constrained();
            $table->string('email');
            $table->string('phone');
            $table->string('subject')->nullable();
            $table->text('text')->nullable();
            $table->boolean('term_privacy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_indices');
    }
};
