<?php

namespace App\Http\Controllers;

use App\Repositories\SettingThemeRepository;
use App\Services\Google\SearchConsoleService;
use App\Services\ThemeManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\GoogleSearchConsoleDaily;
use App\Models\GoogleSearchConsoleQuery;
use App\Models\GoogleSearchConsolePage;
use App\Models\GoogleSearchConsoleDevice;
use App\Models\GoogleSearchConsolePeriod;
use Illuminate\Support\Facades\DB;
use Throwable;
use Carbon\Carbon;

class GoogleSearchConsoleController extends Controller
{
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'testimonials',
            'depoimento.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        $tenants = Tenant::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.blades.google.search-console.index',
            compact(
                'theme',
                'themeData',
                'tenants'
            )
        );
    }

    public function help(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'testimonials',
            'depoimento.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view('admin.blades.google.search-console.help',
            compact(
                'theme',
                'themeData'
            )
        );
    }

    public function connect(
        SearchConsoleService $service
    ): RedirectResponse {
        return redirect()->away(
            $service->getAuthorizationUrl()
        );
    }

    public function callback(
        Request $request,
        SearchConsoleService $service
    ): RedirectResponse {
        if (!$request->filled('code')) {
            return redirect()
                ->route('google.search-console.index')
                ->with('error', 'Autorização do Google não realizada.');
        }

        $service->authenticate(
            $request->string('code')->toString()
        );

        return redirect()
            ->route('google.search-console.index')
            ->with('success', 'Google Search Console conectado com sucesso.');
    }

    public function properties(SearchConsoleService $service) {
        return response()->json(
            $service->getProperties()
        );
    }

    public function performance(
        Request $request,
        Tenant $tenant
    ) {
        $searchConsole = $tenant->googleSearchConsole;

        if (!$searchConsole || !$searchConsole->active) {
            return response()->json([
                'message' => 'Google Search Console não configurado para este site.',
            ], 404);
        }

        $days = (int) $request->input('days', 28);

        if (!in_array($days, [7, 28, 90, 180], true)) {
            $days = 28;
        }

        $endDate = now()->subDay()->toDateString();
        $startDate = now()->subDays($days)->toDateString();

        $previousEndDate = Carbon::parse($startDate)
            ->subDay()
            ->toDateString();

        $previousStartDate = Carbon::parse($previousEndDate)
            ->subDays($days - 1)
            ->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Períodos
        |--------------------------------------------------------------------------
        */

        $currentPeriod = GoogleSearchConsolePeriod::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->first();

        $previousPeriod = GoogleSearchConsolePeriod::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $previousStartDate)
            ->where('end_date', $previousEndDate)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Desempenho diário
        |--------------------------------------------------------------------------
        */

        $dailyRows = GoogleSearchConsoleDaily::query()
            ->where('tenant_id', $tenant->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        $daily = $dailyRows->map(function ($row) {
            return [
                'keys' => [$row->date->toDateString()],
                'clicks' => (float) $row->clicks,
                'impressions' => (float) $row->impressions,
                'ctr' => (float) $row->ctr,
                'position' => (float) $row->position,
            ];
        })->values();

        /*
        |--------------------------------------------------------------------------
        | Consultas
        |--------------------------------------------------------------------------
        */

        $queries = GoogleSearchConsoleQuery::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->orderByDesc('clicks')
            ->get()
            ->map(function ($row) {
                return [
                    'keys' => [$row->query],
                    'clicks' => (float) $row->clicks,
                    'impressions' => (float) $row->impressions,
                    'ctr' => (float) $row->ctr,
                    'position' => (float) $row->position,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Páginas
        |--------------------------------------------------------------------------
        */

        $pages = GoogleSearchConsolePage::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->orderByDesc('clicks')
            ->get()
            ->map(function ($row) {
                return [
                    'keys' => [$row->page],
                    'clicks' => (float) $row->clicks,
                    'impressions' => (float) $row->impressions,
                    'ctr' => (float) $row->ctr,
                    'position' => (float) $row->position,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Dispositivos
        |--------------------------------------------------------------------------
        */

        $devices = GoogleSearchConsoleDevice::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->orderByDesc('clicks')
            ->get()
            ->map(function ($row) {
                return [
                    'keys' => [$row->device],
                    'clicks' => (float) $row->clicks,
                    'impressions' => (float) $row->impressions,
                    'ctr' => (float) $row->ctr,
                    'position' => (float) $row->position,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Comparação de consultas
        |--------------------------------------------------------------------------
        */

        $previousQueries = GoogleSearchConsoleQuery::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $previousStartDate)
            ->where('end_date', $previousEndDate)
            ->orderByDesc('clicks')
            ->get()
            ->map(function ($row) {
                return [
                    'keys' => [$row->query],
                    'clicks' => (float) $row->clicks,
                    'impressions' => (float) $row->impressions,
                    'ctr' => (float) $row->ctr,
                    'position' => (float) $row->position,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Comparação de páginas
        |--------------------------------------------------------------------------
        */

        $previousPages = GoogleSearchConsolePage::query()
            ->where('tenant_id', $tenant->id)
            ->where('start_date', $previousStartDate)
            ->where('end_date', $previousEndDate)
            ->orderByDesc('clicks')
            ->get()
            ->map(function ($row) {
                return [
                    'keys' => [$row->page],
                    'clicks' => (float) $row->clicks,
                    'impressions' => (float) $row->impressions,
                    'ctr' => (float) $row->ctr,
                    'position' => (float) $row->position,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Métricas gerais
        |--------------------------------------------------------------------------
        */

        $overview = [
            'clicks' => (float) ($currentPeriod?->clicks ?? 0),
            'impressions' => (float) ($currentPeriod?->impressions ?? 0),
            'ctr' => (float) ($currentPeriod?->ctr ?? 0),
            'position' => (float) ($currentPeriod?->position ?? 0),
        ];

        $previousOverview = [
            'clicks' => (float) ($previousPeriod?->clicks ?? 0),
            'impressions' => (float) ($previousPeriod?->impressions ?? 0),
            'ctr' => (float) ($previousPeriod?->ctr ?? 0),
            'position' => (float) ($previousPeriod?->position ?? 0),
        ];

        return response()->json([
            'start_date' => $startDate,
            'end_date' => $endDate,

            'previous_start_date' => $previousStartDate,
            'previous_end_date' => $previousEndDate,

            'overview' => $overview,

            'previous_overview' => $previousOverview,

            'daily' => $daily,

            'queries' => $queries,

            'pages' => $pages,

            'devices' => $devices,

            'comparison' => [
                'queries' => [
                    'current' => $queries,
                    'previous' => $previousQueries,
                ],

                'pages' => [
                    'current' => $pages,
                    'previous' => $previousPages,
                ],
            ],
        ]);
    }


    public function sync(
        Request $request,
        Tenant $tenant,
        SearchConsoleService $service
    ) {
        $searchConsole = $tenant->googleSearchConsole;

        if (!$searchConsole || !$searchConsole->active) {
            return response()->json([
                'message' => 'Google Search Console não configurado para este site.',
            ], 404);
        }

        $requestedDays = (int) $request->input('days', 28);

        if (!in_array($requestedDays, [7, 28, 90, 180], true)) {
            $requestedDays = 28;
        }

        $periods = [7, 28, 90, 180];

        try {
            $syncedPeriods = [];

            foreach ($periods as $days) {
                $currentEndDate = now()
                    ->subDay()
                    ->toDateString();

                $currentStartDate = now()
                    ->subDays($days)
                    ->toDateString();

                $previousEndDate = Carbon::parse($currentStartDate)
                    ->subDay()
                    ->toDateString();

                $previousStartDate = Carbon::parse($previousEndDate)
                    ->subDays($days - 1)
                    ->toDateString();

                $currentData = $service->getDashboardDataForPeriod(
                    $searchConsole->property,
                    $currentStartDate,
                    $currentEndDate
                );

                $previousData = $service->getDashboardDataForPeriod(
                    $searchConsole->property,
                    $previousStartDate,
                    $previousEndDate
                );

                DB::transaction(function () use (
                    $tenant,
                    $currentData,
                    $previousData
                ) {
                    $this->saveSearchConsolePeriod(
                        $tenant,
                        $currentData
                    );

                    $this->saveSearchConsolePeriod(
                        $tenant,
                        $previousData
                    );
                });

                $syncedPeriods[] = [
                    'days' => $days,
                    'current' => [
                        'start_date' => $currentStartDate,
                        'end_date' => $currentEndDate,
                    ],
                    'previous' => [
                        'start_date' => $previousStartDate,
                        'end_date' => $previousEndDate,
                    ],
                ];
            }

            $searchConsole->update([
                'last_synced_at' => now(),
                'last_sync_status' => 'success',
                'last_sync_error' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dados do Google Search Console sincronizados com sucesso.',
                'requested_days' => $requestedDays,
                'periods' => $syncedPeriods,
                'last_synced_at' => now()->toISOString(),
            ]);
        } catch (Throwable $e) {
            $searchConsole->update([
                'last_sync_status' => 'error',
                'last_sync_error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Não foi possível sincronizar os dados do Google Search Console.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function saveSearchConsolePeriod(
        Tenant $tenant,
        array $data
    ): void {
        GoogleSearchConsolePeriod::updateOrCreate(
            [
                'tenant_id' => $tenant->id,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ],
            [
                'clicks' => $data['overview']['clicks'] ?? 0,
                'impressions' => $data['overview']['impressions'] ?? 0,
                'ctr' => $data['overview']['ctr'] ?? 0,
                'position' => $data['overview']['position'] ?? 0,
            ]
        );
        foreach ($data['daily'] ?? [] as $row) {
            $date = $row['keys'][0] ?? null;

            if (!$date) {
                continue;
            }

            GoogleSearchConsoleDaily::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'date' => $date,
                ],
                [
                    'clicks' => $row['clicks'] ?? 0,
                    'impressions' => $row['impressions'] ?? 0,
                    'ctr' => $row['ctr'] ?? 0,
                    'position' => $row['position'] ?? 0,
                ]
            );
        }

        foreach ($data['queries'] ?? [] as $row) {
            $query = $row['keys'][0] ?? null;

            if (!$query) {
                continue;
            }

            GoogleSearchConsoleQuery::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'query_hash' => hash('sha256', $query),
                ],
                [
                    'query' => $query,
                    'clicks' => $row['clicks'] ?? 0,
                    'impressions' => $row['impressions'] ?? 0,
                    'ctr' => $row['ctr'] ?? 0,
                    'position' => $row['position'] ?? 0,
                ]
            );
        }

        foreach ($data['pages'] ?? [] as $row) {
            $page = $row['keys'][0] ?? null;

            if (!$page) {
                continue;
            }

            GoogleSearchConsolePage::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'page_hash' => hash('sha256', $page),
                ],
                [
                    'page' => $page,
                    'clicks' => $row['clicks'] ?? 0,
                    'impressions' => $row['impressions'] ?? 0,
                    'ctr' => $row['ctr'] ?? 0,
                    'position' => $row['position'] ?? 0,
                ]
            );
        }

        foreach ($data['devices'] ?? [] as $row) {
            $device = $row['keys'][0] ?? null;

            if (!$device) {
                continue;
            }

            GoogleSearchConsoleDevice::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'device' => $device,
                ],
                [
                    'clicks' => $row['clicks'] ?? 0,
                    'impressions' => $row['impressions'] ?? 0,
                    'ctr' => $row['ctr'] ?? 0,
                    'position' => $row['position'] ?? 0,
                ]
            );
        }
    }
}