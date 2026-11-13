<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdSlot;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\JsonResponse;

class AnnoumcementsController extends Controller
{
    public function index(ThemeManager $themeManager): JsonResponse
    {
        $tenant = Tenant::current();
        $theme = $themeManager->theme();

        $announcements = collect();

        if ($tenant && $theme) {
            $adSlots = AdSlot::query()
                ->where('template_theme_id', $theme->id)
                ->where('active', true)
                ->with([
                    'announcements' => function ($query) use ($tenant) {
                        $query
                            ->select([
                                'announcements.id',
                                'link',
                                'path_image',
                                'path_image_mobile',
                                'path_image_vertical',
                                'text',
                                'type',
                                'sorting',
                                'starts_at',
                                'ends_at',
                            ])
                            ->where('active', true)
                            ->whereIn('display_location', ['panel', 'both'])
                            ->where(function ($query) use ($tenant) {
                                $query
                                    ->where('target', 'all')
                                    ->orWhere(function ($query) use ($tenant) {
                                        $query
                                            ->where('target', 'specific')
                                            ->whereHas('tenants', function ($query) use ($tenant) {
                                                $query->where('tenants.id', $tenant->id);
                                            });
                                    });
                            })
                            ->where(function ($query) {
                                $query
                                    ->whereNull('starts_at')
                                    ->orWhere('starts_at', '<=', now());
                            })
                            ->where(function ($query) {
                                $query
                                    ->whereNull('ends_at')
                                    ->orWhere('ends_at', '>=', now());
                            })
                            ->orderByDesc('announcements.created_at');
                    },
                ])
                ->orderBy('sorting')
                ->orderBy('name')
                ->get();

            $announcements = $adSlots->mapWithKeys(function ($adSlot) {
                return [
                    $adSlot->slug => $adSlot->announcements
                        ->map(fn ($announcement) => $announcement->only([
                            'id',
                            'link',
                            'path_image',
                            'path_image_mobile',
                            'path_image_vertical',
                            'text',
                            'type',
                            'sorting',
                            'starts_at',
                            'ends_at',
                        ]))
                        ->values(),
                ];
            });
        }

        return response()->json([
            'data' => $announcements,
        ]);
    }
}
