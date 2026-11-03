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
        Schema::table('advantages', function (Blueprint $table) {
            $table->string('path_icon')->nullable();
            $table->enum('for_you', ['persona', 'enterprise'])->default('persona');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advantages', function (Blueprint $table) {
            //
        });
    }
};
