<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('google_search_console_queries', function (Blueprint $table) {
            $table->dropUnique('gsc_queries_unique');

            $table->text('query')->change();

            $table->char('query_hash', 64)
                ->nullable()
                ->after('query');
        });

        DB::statement("
            UPDATE google_search_console_queries
            SET query_hash = SHA2(query, 256)
            WHERE query_hash IS NULL
        ");

        Schema::table('google_search_console_queries', function (Blueprint $table) {
            $table->char('query_hash', 64)
                ->nullable(false)
                ->change();

            $table->unique(
                [
                    'tenant_id',
                    'start_date',
                    'end_date',
                    'query_hash',
                ],
                'google_search_console_queries_period_hash_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('google_search_console_queries', function (Blueprint $table) {
            $table->dropUnique(
                'google_search_console_queries_period_hash_unique'
            );

            $table->dropColumn('query_hash');

            $table->string('query', 500)->change();

            $table->unique(
                [
                    'tenant_id',
                    'start_date',
                    'end_date',
                    'query',
                ],
                'gsc_queries_unique'
            );
        });
    }
};