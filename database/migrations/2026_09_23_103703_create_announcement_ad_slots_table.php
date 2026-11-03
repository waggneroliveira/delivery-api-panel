<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_ad_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('announcement_id')
                ->constrained('announcements')
                ->cascadeOnDelete();

            $table->foreignId('ad_slot_id')
                ->constrained('ad_slots')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'announcement_id',
                'ad_slot_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_ad_slots');
    }
};