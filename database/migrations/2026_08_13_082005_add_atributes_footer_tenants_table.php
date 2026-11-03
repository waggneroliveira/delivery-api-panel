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
        if (!Schema::hasColumn('tenants', 'text_color_footer')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('text_color_footer')->default('#FFF');
            });
        }

        if (!Schema::hasColumn('tenants', 'bg_footer')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('bg_footer')->default('#000');
            });
        }

        if (!Schema::hasColumn('tenants', 'btn_title')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('btn_title')->nullable();
            });
        }

        if (!Schema::hasColumn('tenants', 'description')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('description')->nullable();
            });
        }

        if (!Schema::hasColumn('tenants', 'link')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->string('link')->nullable();
            });
        }

        if (!Schema::hasColumn('tenants', 'cnpj')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->char('cnpj', 14)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'text_color_footer',
                'bg_footer',
                'btn_title',
                'description',
                'link',
                'cnpj',
            ]);
        });
    }
};
