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
        if (!Schema::hasTable('plan_network_categories')) {
            Schema::create('plan_network_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->boolean('active')->default(0);
                $table->integer('sorting')->default(0);
                $table->string('path_image')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_network_categories');
    }
};
