<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('template_themes', 'tenant_id')) {
            Schema::table('template_themes', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('template_themes', 'tenant_id')) {
            Schema::table('template_themes', function (Blueprint $table) {
                $table->foreignId('tenant_id')
                    ->nullable()
                    ->constrained('tenants')
                    ->nullOnDelete();
            });
        }
    }
};