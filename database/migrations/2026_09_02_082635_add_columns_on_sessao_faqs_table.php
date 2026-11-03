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
        Schema::table('sessao_faqs', function (Blueprint $table) {
            $table->string('tag')->nullable();
            $table->string('title_box')->nullable();
            $table->string('description_box')->nullable();
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessao_faqs', function (Blueprint $table) {
            //
        });
    }
};
