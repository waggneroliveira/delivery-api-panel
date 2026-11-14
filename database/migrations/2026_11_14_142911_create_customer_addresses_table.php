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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title')->default('Casa');
            $table->string('recipient_name');

            $table->string('zip_code', 9);
            $table->string('state', 2);
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->text('reference')->nullable();

            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
