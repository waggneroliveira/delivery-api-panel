<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('benefit_topics', function (Blueprint $table) {
            // Altera o tipo para string e mantém como nullable
            $table->string('number')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('benefit_topics', function (Blueprint $table) {
            // Reverte a coluna para integer caso precise desfazer a migration
            $table->integer('number')->nullable()->change();
        });
    }
};