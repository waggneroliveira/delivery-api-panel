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
        Schema::table('seo_googles', function (Blueprint $table) {
            $table->string('search_console')->nullable()->after('tenant_id');
            $table->string('google_tag_manager')->nullable()->after('search_console');
            $table->string('google_ads')->nullable()->after('google_tag_manager');
            $table->string('meta_pixel')->nullable()->after('google_ads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_googles', function (Blueprint $table) {
            $table->dropColumn([
                'search_console',
                'google_tag_manager',
                'google_ads',
                'meta_pixel',
            ]);
        });
    }
};
