<?php

namespace App\Modules\Client\Business;

use App\Models\About;
use App\Models\AdSlot;
use App\Models\BenefitTopic;
use App\Models\Contact;
use App\Models\Direction;
use App\Models\Partner;
use App\Models\Report;
use App\Models\ServiceLocation;
use App\Models\Statute;
use App\Models\Tenant;
use App\Models\Topic;
use App\Models\Video;
use App\Services\ThemeManager;

class AboutPageService
{
    public function getPageData(ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $adSlots = AdSlot::query()
            ->where('template_theme_id', $themeData->id)
            ->where('active', true)
            ->with([
                'announcements' => function ($query) use ($tenantTheme) {
                    $query
                        ->where('active', true)
                        ->whereIn('display_location', ['web', 'both'])
                        ->where(function ($query) use ($tenantTheme) {
                            $query
                                ->where('target', 'all')
                                ->orWhere(function ($query) use ($tenantTheme) {
                                    $query
                                        ->where('target', 'specific')
                                        ->whereHas('tenants', function ($query) use ($tenantTheme) {
                                            $query->where('tenants.id', $tenantTheme->id);
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
                        ->latest();
                },
            ])
            ->orderBy('sorting')
            ->orderBy('name')
            ->get();

        $announcements = $adSlots->mapWithKeys(function ($adSlot) {
            return [
                $adSlot->slug => $adSlot->announcements,
            ];
        });

        return [
            'about' => About::active()->first(),
            'topics' => Topic::active()->sorting()->get(),
            'benefitTopics' => BenefitTopic::active()->sorting()->get(),
            'partners' => Partner::active()->sorting()->get(),
            'contact' => Contact::first(),
            'statute' => Statute::active()->first(),
            'directions' => Direction::active()->sorting()->get(),
            'video' => Video::active()->first(),
            'reports' => Report::active()->get(),
            'serviceLocation' => ServiceLocation::active()->first(),
            'theme' => $theme,
            'themeData' => $themeData,
            'tenantTheme' => $tenantTheme,
            'announcements' => $announcements,
        ];
    }
}
