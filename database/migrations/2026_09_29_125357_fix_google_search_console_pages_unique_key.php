<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('google_search_console_pages', function (Blueprint $table) {
            $table->dropUnique('gsc_pages_unique');

            $table->text('page')->change();

            $table->char('page_hash', 64)
                ->nullable()
                ->after('page');
        });

        DB::statement("
            UPDATE google_search_console_pages
            SET page_hash = SHA2(page, 256)
            WHERE page_hash IS NULL
        ");

        Schema::table('google_search_console_pages', function (Blueprint $table) {
            $table->char('page_hash', 64)
                ->nullable(false)
                ->change();

            $table->unique(
                [
                    'tenant_id',
                    'start_date',
                    'end_date',
                    'page_hash',
                ],
                'google_search_console_pages_period_hash_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('google_search_console_pages', function (Blueprint $table) {
            $table->dropUnique(
                'google_search_console_pages_period_hash_unique'
            );

            $table->dropColumn('page_hash');

            $table->string('page', 500)->change();

            $table->unique(
                [
                    'tenant_id',
                    'start_date',
                    'end_date',
                    'page',
                ],
                'gsc_pages_unique'
            );
        });
    }
};