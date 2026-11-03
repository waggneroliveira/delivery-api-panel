<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FootballDataService
{
    public function getBrasileiraoStandings(): array
    {
        $apiKey = '4754b23a33e54b2a9403bf1f87df7ca4';

        $standings = Cache::remember('tabela_brasileirao', 900, function () use ($apiKey) {

            $response = Http::withoutVerifying()
                ->withHeaders([
                    'X-Auth-Token' => $apiKey,
                ])
                ->get('https://api.football-data.org/v4/competitions/BSA/standings');

            if ($response->successful()) {
                $data = $response->json();

                return $data['standings'][0]['table'] ?? [];
            }

            Log::error('Erro ao buscar tabela do Brasileirão', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        });

        if (empty($standings)) {
            Cache::forget('tabela_brasileirao');
        }

        return $standings;
    }

    public function getBrasileiraoNextMatchday(): array
    {
        $apiKey = '4754b23a33e54b2a9403bf1f87df7ca4';

        $nextMatches = Cache::remember('proxima_rodada_brasileirao', 900, function () use ($apiKey) {

            // 1. Busca os jogos agendados (SCHEDULED)
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'X-Auth-Token' => $apiKey,
                ])
                ->get('https://api.football-data.org/v4/competitions/BSA/matches', [
                    'status' => 'SCHEDULED',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $matches = $data['matches'] ?? [];

                if (empty($matches)) {
                    return [];
                }

                // 2. Identifica o número do próximo matchday (rodada) a partir do primeiro jogo futuro
                $nextMatchday = $matches[0]['matchday'] ?? null;

                // 3. Filtra a lista mantendo apenas os jogos pertencentes a essa rodada
                return array_values(array_filter($matches, function ($match) use ($nextMatchday) {
                    return $match['matchday'] === $nextMatchday;
                }));
            }

            Log::error('Erro ao buscar jogos do Brasileirão', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        });

        if (empty($nextMatches)) {
            Cache::forget('proxima_rodada_brasileirao');
        }

        return $nextMatches;
    }
}