<?php

namespace App\Modules\Client\Business;

use App\Models\TemplateTheme;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class TemplatePageService
{
    public function getTemplateListData(Request $request, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $search = $request->input('search');
        $templateThemes = TemplateTheme::active();
        
        if ($search) {
            $templateThemes = $templateThemes->where('name', 'like', '%' . $search . '%');
        }

        $templateThemes = $templateThemes->paginate('18');

        $uniqueThemes = TemplateTheme::active()
            ->distinct()
            ->pluck('name', 'slug')
            ->toArray();
  
        return compact('templateThemes', 'uniqueThemes', 'theme', 'themeData', 'tenantTheme');
    }

    public function getInnerData($slug = null, $templateVariation = null, ThemeManager $themeManager): array
    {
        $templateThemeInner = TemplateTheme::where('slug', $slug)->where('template_variation', $templateVariation)
            ->active()
            ->first();

        if (!$templateThemeInner) {
            return ['view' => 'client.themes.whi-web.tp-01.errors.404'];
        }

        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return compact(
            'templateThemeInner',
            'theme',
            'themeData',
            'tenantTheme',
            'templateVariation'
        );
    }
}
