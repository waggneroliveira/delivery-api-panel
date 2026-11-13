<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AppearanceController extends Controller
{
    public function show(): JsonResponse
    {
        $tenant = Tenant::current();

        abort_unless($tenant instanceof Tenant, 404, 'Cliente não encontrado.');

        $logo = $tenant->path_image_logo_header
            ? Storage::disk('public')->url($tenant->path_image_logo_header)
            : null;

        return response()
            ->json([
                'name' => $tenant->name,
                'logo' => $logo,
                'colors' => [
                    'primary' => $tenant->primary_color ?: '#f36b18',
                    'secondary' => $tenant->secondary_color ?: '#24211f',
                    'background' => $tenant->bg_header ?: '#fef3e5',
                    'text' => $tenant->text_color ?: '#262321',
                ],
            ])
            ->header('Cache-Control', 'public, max-age=60');
    }
}
