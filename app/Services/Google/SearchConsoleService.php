<?php

namespace App\Services\Google;

use App\Models\GoogleCredential;
use Google\Client;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SearchConsoleService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();

        $this->client->setClientId(
            config('services.google_search_console.client_id')
        );

        $this->client->setClientSecret(
            config('services.google_search_console.client_secret')
        );

        $this->client->setRedirectUri(
            config('services.google_search_console.redirect')
        );

        $this->client->setAccessType('offline');

        $this->client->setPrompt('consent');

        $this->client->setScopes([
            'https://www.googleapis.com/auth/webmasters.readonly',
        ]);
    }

    public function getAuthorizationUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function authenticate(string $code): GoogleCredential
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            throw new RuntimeException(
                $token['error_description']
                ?? 'Erro ao autenticar com o Google.'
            );
        }

        return GoogleCredential::updateOrCreate(
            [
                'provider' => 'search_console',
            ],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_at' => now()->addSeconds(
                    $token['expires_in'] ?? 3600
                ),
            ]
        );
    }

    protected function getAccessToken(): string
    {
        $credential = GoogleCredential::where(
            'provider',
            'search_console'
        )->first();

        if (!$credential) {
            throw new RuntimeException(
                'Google Search Console ainda não foi conectado.'
            );
        }

        $this->client->setAccessToken([
            'access_token' => $credential->access_token,
            'refresh_token' => $credential->refresh_token,
            'expires_in' => $credential->expires_at
                ? max(
                    0,
                    now()->diffInSeconds(
                        $credential->expires_at,
                        false
                    )
                )
                : 0,
        ]);

        if ($this->client->isAccessTokenExpired()) {
            if (!$credential->refresh_token) {
                throw new RuntimeException(
                    'O token do Google expirou e não possui refresh token.'
                );
            }

            $token = $this->client->fetchAccessTokenWithRefreshToken(
                $credential->refresh_token
            );

            if (isset($token['error'])) {
                throw new RuntimeException(
                    $token['error_description']
                    ?? 'Não foi possível renovar o token do Google.'
                );
            }

            $credential->update([
                'access_token' => $token['access_token'],
                'expires_at' => now()->addSeconds(
                    $token['expires_in'] ?? 3600
                ),
            ]);
        }

        return $this->client->getAccessToken()['access_token'];
    }

    public function getProperties(): array
    {
        $response = Http::withToken(
            $this->getAccessToken()
        )->get(
            'https://www.googleapis.com/webmasters/v3/sites'
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'Erro ao consultar propriedades do Search Console: '
                . $response->body()
            );
        }

        return $response->json('siteEntry', []);
    }    


    public function getDashboardData(string $property, int $days = 28): array
    {
        $endDate = now()->subDay()->toDateString();
        $startDate = now()->subDays($days)->toDateString();

        return $this->getDashboardDataForPeriod(
            $property,
            $startDate,
            $endDate
        );
    }

    public function getDashboardDataForPeriod(
        string $property,
        string $startDate,
        string $endDate
    ): array {
        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'overview' => $this->getOverview(
                $property,
                $startDate,
                $endDate
            ),
            'daily' => $this->getDaily(
                $property,
                $startDate,
                $endDate
            ),
            'queries' => $this->getQueries(
                $property,
                $startDate,
                $endDate
            ),
            'pages' => $this->getPages(
                $property,
                $startDate,
                $endDate
            ),
            'devices' => $this->getDevices(
                $property,
                $startDate,
                $endDate
            ),
        ];
    }

    protected function getOverview(
    string $property,
    string $startDate,
    string $endDate
    ): array {
        $response = $this->query(
            $property,
            $startDate,
            $endDate
        );

        $rows = $response['rows'] ?? [];

        if (!$rows) {
            return [
                'clicks' => 0,
                'impressions' => 0,
                'ctr' => 0,
                'position' => 0,
            ];
        }

        $row = $rows[0];

        return [
            'clicks' => $row['clicks'] ?? 0,
            'impressions' => $row['impressions'] ?? 0,
            'ctr' => $row['ctr'] ?? 0,
            'position' => $row['position'] ?? 0,
        ];
    }

    protected function getDaily(
    string $property,
    string $startDate,
    string $endDate
    ): array {
        $response = $this->query(
            $property,
            $startDate,
            $endDate,
            ['date']
        );

        return $response['rows'] ?? [];
    }

    protected function getQueries(
        string $property,
        string $startDate,
        string $endDate,
        int $rowLimit = 25000
    ): array {
        $response = $this->query(
            $property,
            $startDate,
            $endDate,
            ['query'],
            $rowLimit
        );

        return $response['rows'] ?? [];
    }

    protected function getPages(
        string $property,
        string $startDate,
        string $endDate,
        int $rowLimit = 25000
    ): array {
        $response = $this->query(
            $property,
            $startDate,
            $endDate,
            ['page'],
            $rowLimit
        );

        return $response['rows'] ?? [];
    }

    protected function getDevices(
        string $property,
        string $startDate,
        string $endDate,
        int $rowLimit = 25000
    ): array
    {
        $response = $this->query(
            $property,
            $startDate,
            $endDate,
            ['device'],
            $rowLimit
        );

        return $response['rows'] ?? [];
    }

    protected function query(
    string $property,
    string $startDate,
    string $endDate,
    array $dimensions = [],
    int $rowLimit = 25000
    ): array {
        $response = Http::withToken(
            $this->getAccessToken()
        )->post(
            'https://www.googleapis.com/webmasters/v3/sites/'
            . rawurlencode($property)
            . '/searchAnalytics/query',
            [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'dimensions' => $dimensions,
                'type' => 'web',
                'rowLimit' => $rowLimit,
            ]
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'Erro ao consultar Search Console: '
                . $response->body()
            );
        }

        return $response->json();
    }
}