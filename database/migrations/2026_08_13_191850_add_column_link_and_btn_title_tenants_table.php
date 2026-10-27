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
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'btn_title_header')) {
                Schema::table('tenants', function (Blueprint $table) {
                    $table->string('btn_title_header')->nullable();
                });
            }

            if (!Schema::hasColumn('tenants', 'link_header')) {
                Schema::table('tenants', function (Blueprint $table) {
                    $table->string('link_header')->nullable();
                });
            }
            
            if (!Schema::hasColumn('tenants', 'privacy_policy')) {
                Schema::table('tenants', function (Blueprint $table) {
                    $table->text('privacy_policy')->nullable();
                });
            }

            if (!Schema::hasColumn('tenants', 'terms_of_use')) {
                Schema::table('tenants', function (Blueprint $table) {
                    $table->text('terms_of_use')->nullable();
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            //
        });
    }
};
