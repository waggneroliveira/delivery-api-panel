<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Temporariamente transforma em TEXT
        |--------------------------------------------------------------------------
        |
        | Isso evita o limite de 255 caracteres caso a coluna atual seja
        | VARCHAR(255).
        |
        */
        Schema::table('template_themes', function (Blueprint $table) {
            $table->text('preview')->nullable()->change();
        });

        /*
        |--------------------------------------------------------------------------
        | 2. Converte os dados existentes para JSON
        |--------------------------------------------------------------------------
        */

        $themes = DB::table('template_themes')
            ->whereNotNull('preview')
            ->where('preview', '!=', '')
            ->get(['id', 'preview']);

        foreach ($themes as $theme) {
            $preview = trim($theme->preview);

            /*
            | Se já for um JSON válido contendo um array,
            | mantém exatamente como está.
            */
            $decoded = json_decode($preview, true);

            if (
                json_last_error() === JSON_ERROR_NONE &&
                is_array($decoded)
            ) {
                continue;
            }

            /*
            | Caso seja um caminho antigo de uma única imagem,
            | transforma em array JSON.
            */
            $json = json_encode(
                [$preview],
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );

            DB::table('template_themes')
                ->where('id', $theme->id)
                ->update([
                    'preview' => $json,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Agora transforma a coluna definitivamente em JSON
        |--------------------------------------------------------------------------
        */
        Schema::table('template_themes', function (Blueprint $table) {
            $table->json('preview')->nullable()->change();
        });
    }

    public function down(): void
    {
        /*
        | Volta para TEXT sem destruir o JSON.
        |
        | Isso é importante: não vamos pegar apenas [0] e perder
        | as demais imagens.
        */
        Schema::table('template_themes', function (Blueprint $table) {
            $table->text('preview')->nullable()->change();
        });
    }
};