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
        if (!Schema::hasTable('plan_networks')) {
            Schema::create('plan_networks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();
                $table->foreignId('plan_network_category')->constrained()->onDelete('cascade');
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->integer('bandwidth_limit')->nullable();
                $table->string('bandwidth_unit')->nullable();
                $table->string('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->boolean('active')->default(0);
                $table->integer('sorting')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_networks');
    }
};
