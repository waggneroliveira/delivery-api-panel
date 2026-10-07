<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantModuleLimit;
use Illuminate\Http\Request;

class TenantModuleLimitController extends Controller
{
    public function index(){
        $tenant = Tenant::current();

        $templateSlug = $tenant->templateTheme->slug;

        $templateLimits = config(
            "template_modules.{$templateSlug}.limits",
            []
        );

        return view('admin.blades.template-limite.index', [
            'tenant' => $tenant,
            'templateLimits' => $templateLimits,
        ]);
    }
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'limits' => ['required', 'array'],
            'limits.*' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($validated['limits'] as $module => $limit) {

            if ($limit === null) {
                TenantModuleLimit::query()
                    ->where('tenant_id', $tenant->id)
                    ->where('module', $module)
                    ->delete();

                continue;
            }

            TenantModuleLimit::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'module' => $module,
                ],
                [
                    'limit' => $limit,
                ]
            );
        }

        return back()->with(
            'success',
            'Limites atualizados com sucesso.'
        );
    }
}