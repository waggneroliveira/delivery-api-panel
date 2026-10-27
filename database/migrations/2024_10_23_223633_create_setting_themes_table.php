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
        Schema::create('setting_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('data_bs_theme');
            $table->string('data_layout_width');
            $table->string('data_layout_mode');
            $table->string('data_topbar_color');
            $table->string('data_menu_color');
            $table->string('data_two_column_color');
            $table->string('data_menu_icon');
            $table->string('data_sidenav_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_themes');
    }
};
