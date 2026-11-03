<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('directions', 'function')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->string('function')->nullable();
            });
        }

        if (!Schema::hasColumn('directions', 'instagram')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->string('instagram')->nullable();
            });
        }

        if (!Schema::hasColumn('directions', 'linkedin')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->string('linkedin')->nullable();
            });
        }

        if (!Schema::hasColumn('directions', 'facebook')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->string('facebook')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('directions', 'function')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->dropColumn('function');
            });
        }

        if (Schema::hasColumn('directions', 'instagram')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->dropColumn('instagram');
            });
        }

        if (Schema::hasColumn('directions', 'linkedin')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->dropColumn('linkedin');
            });
        }

        if (Schema::hasColumn('directions', 'facebook')) {
            Schema::table('directions', function (Blueprint $table) {
                $table->dropColumn('facebook');
            });
        }
    }
};
