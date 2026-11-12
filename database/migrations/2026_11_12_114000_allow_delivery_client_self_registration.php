<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicatePhone = DB::table('clients')
            ->select('tenant_id', 'phone')
            ->groupBy('tenant_id', 'phone')
            ->havingRaw('COUNT(*) > 1')
            ->first();

        if ($duplicatePhone) {
            throw new RuntimeException(
                'Não é possível habilitar o cadastro pela API: há telefones duplicados no mesmo tenant.'
            );
        }

        Schema::table('clients', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->unique(['tenant_id', 'phone']);
        });
    }

    public function down(): void
    {
        if (DB::table('clients')->whereNull('email')->orWhereNull('password')->exists()) {
            throw new RuntimeException(
                'Preencha email e senha das contas de delivery antes de reverter esta migration.'
            );
        }

        Schema::table('clients', function (Blueprint $table) {
            $table->dropUnique(['tenant_id', 'phone']);
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
