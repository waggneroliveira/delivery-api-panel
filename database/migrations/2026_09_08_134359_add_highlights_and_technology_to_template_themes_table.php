<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_themes', function (Blueprint $table) {
            $table->text('highlights')->nullable();
            $table->string('technology')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('template_themes', function (Blueprint $table) {
            $table->dropColumn(['highlights', 'technology']);
        });
    }
};
