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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('name_section')->nullable();
            $table->string('name_section_social_media')->nullable();
            $table->string('mention')->nullable();
            $table->string('text')->nullable();
            $table->string('name_one')->nullable();
            $table->string('name_two')->nullable();
            $table->string('name_three')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('address_three')->nullable();
            $table->string('opening_hours_one')->nullable();
            $table->string('opening_hours_two')->nullable();
            $table->string('opening_hours_three')->nullable();
            $table->string('phone_one')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('phone_three')->nullable();
            $table->string('link_insta')->nullable();
            $table->string('link_x')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_face')->nullable();
            $table->string('link_tik_tok')->nullable();
            $table->text('maps')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
