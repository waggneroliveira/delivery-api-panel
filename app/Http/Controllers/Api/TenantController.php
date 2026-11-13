<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\JsonResponse;

class TenantController extends Controller
{
    public function show(ThemeManager $themeManager): JsonResponse
    {
        $tenant = Tenant::current();

        abort_unless($tenant instanceof Tenant, 404, 'Cliente não encontrado.');

        $tenantData = $tenant->only([
            'id',
            'name',
            'slug',
            'primary_color',
            'secondary_color',
            'accent_color',
            'text_color',
            'path_image_logo_header',
            'path_image_logo_footer',
            'text_button_one',
            'color_button_one',
            'bg_button_one',
            'text_button_two',
            'color_button_two',
            'bg_button_two',
            'text_color_header',
            'bg_header',
            'bg_scroll',
            'btn_title_header',
            'link_header',
            'privacy_policy',
            'terms_of_use',
            'btn_title',
            'description',
            'link',
            'bg_footer',
            'text_color_footer',
            'cnpj',
            'copyright',
        ]);

        $theme = $themeManager->theme();

        return response()->json([
            'data' => [
                'tenant' => $tenantData,
                'theme' => $theme?->only([
                    'id',
                    'slug',
                    'name',
                    'layout_type',
                    'template_variation',
                ]),
            ],
        ]);
    }
}
