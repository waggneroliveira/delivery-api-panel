<?php

namespace App\Modules\Admin\Business;

use App\Models\Announcement;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getDashboardData(ThemeManager $themeManager): array
    {
        $currentUser = Auth::user();
        $user = User::where('id', $currentUser->id)->active()->first();
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $clients = Tenant::with(['templateTheme', 'plan'])->orderBy('name', 'asc')->paginate(4);

        $tenant = Tenant::current();

        $announcement = Announcement::query()
        ->where('active', true)
        ->whereIn('display_location', ['panel', 'both'])
        ->where(function ($query) use ($tenant) {
            $query->where('target', 'all')
                ->orWhereHas('tenants', function ($query) use ($tenant) {
                    $query->where('tenants.id', $tenant->id);
                });
        })
        ->where(function ($query) {
            $query->whereNull('starts_at')
                ->orWhere('starts_at', '<=', now());
        })
        ->where(function ($query) {
            $query->whereNull('ends_at')
                ->orWhere('ends_at', '>=', now());
        })
        ->latest()
        ->first();

        

        return compact('user', 'settingTheme', 'theme', 'themeData', 'clients', 'announcement');
    }
}
