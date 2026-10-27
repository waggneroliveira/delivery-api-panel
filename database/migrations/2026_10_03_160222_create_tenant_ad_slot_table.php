<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_ad_slot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('ad_slot_id')
                ->constrained('ad_slots')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['tenant_id', 'ad_slot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_ad_slot');
    }
};