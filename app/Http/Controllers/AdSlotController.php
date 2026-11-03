<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdSlot;
use App\Models\Tenant;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdSlotController extends Controller
{
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $themeData = $themeManager->theme();

        $adSlots = AdSlot::where(
            'template_theme_id',
            $themeData->id
        )
        ->withCount([
            'announcements',
            'tenants',
        ])
        ->orderBy('sorting')
        ->orderBy('name')
        ->get();

        return view('admin.blades.adSlot.index',
            compact(
                'adSlots',
                'themeData',
                'themeManager'
            )
        );
    }

    public function create(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.criar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }
        $tenants = Tenant::orderBy('name')->get();
        $themeData = $themeManager->theme();

        return view('admin.blades.adSlot.create',
            compact(
                'tenants',
                'themeData',
                'themeManager'
            )
        );
    }

    public function store(Request $request, ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.criar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $themeData = $themeManager->theme();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('ad_slots', 'slug')
                    ->where(
                        fn ($query) => $query->where(
                            'template_theme_id',
                            $themeData->id
                        )
                    ),
            ],
            'exhibition' => [
                'required',
                Rule::in([
                    'horizontal',
                    'mobile',
                    'vertical',
                ]),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'sorting' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'active' => [
                'nullable',
                'boolean',
            ],

            // Tenants autorizados a utilizar este espaço
            'tenant_ids' => [
                'nullable',
                'array',
            ],

            'tenant_ids.*' => [
                'integer',
                'exists:tenants,id',
            ],
        ]);

        $slug = $validated['slug'] ?? $validated['name'];

        $slug = Str::slug($slug);

        /*
        * Garante que o slug seja único dentro do template.
        */
        $originalSlug = $slug;
        $counter = 1;

        while (
            AdSlot::where('template_theme_id', $themeData->id)
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $adSlot = AdSlot::create([
            'template_theme_id' => $themeData->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'exhibition' => $validated['exhibition'],
            'description' => $validated['description'] ?? null,
            'sorting' => $validated['sorting'] ?? 0,
            'active' => $request->boolean('active'),
        ]);

        /*
        * Define quais tenants possuem acesso ao espaço.
        */
        $adSlot->tenants()->sync(
            $validated['tenant_ids'] ?? []
        );

        return redirect()
            ->route('admin.dashboard.adSlot.index')
            ->with(
                'success',
                'Espaço de anúncio criado com sucesso.'
            );
    }

    public function show(
        AdSlot $adSlot,
        ThemeManager $themeManager
    ) {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $themeData = $themeManager->theme();

        $this->ensureBelongsToCurrentTheme(
            $adSlot,
            $themeData->id
        );

        $adSlot->load('announcements');

        return view(
            'admin.blades.adSlot.show',
            compact(
                'adSlot',
                'themeData',
                'themeManager'
            )
        );
    }

    public function edit(
        AdSlot $adSlot,
        ThemeManager $themeManager
    ) {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.editar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $themeData = $themeManager->theme();

        $this->ensureBelongsToCurrentTheme(
            $adSlot,
            $themeData->id
        );
        
        $tenants = Tenant::orderBy('name')->get();

        $adSlot->load('tenants');

        return view(
            'admin.blades.adSlot.edit',
            compact(
                'tenants',
                'adSlot',
                'themeData',
                'themeManager'
            )
        );
    }

    public function update(
        Request $request,
        AdSlot $adSlot,
        ThemeManager $themeManager
    ) {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.editar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $themeData = $themeManager->theme();

        $this->ensureBelongsToCurrentTheme(
            $adSlot,
            $themeData->id
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('ad_slots', 'slug')
                    ->ignore($adSlot->id)
                    ->where(
                        fn ($query) => $query->where(
                            'template_theme_id',
                            $themeData->id
                        )
                    ),
            ],
            'exhibition' => [
                'required',
                Rule::in([
                    'horizontal',
                    'mobile',
                    'vertical',
                ]),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'sorting' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'active' => [
                'nullable',
                'boolean',
            ],

            // Tenants autorizados a utilizar este espaço
            'tenant_ids' => [
                'nullable',
                'array',
            ],

            'tenant_ids.*' => [
                'integer',
                'exists:tenants,id',
            ],
        ]);

        $slug = $validated['slug'] ?? $validated['name'];

        $slug = Str::slug($slug);

        $originalSlug = $slug;
        $counter = 1;

        while (
            AdSlot::where('template_theme_id', $themeData->id)
                ->where('slug', $slug)
                ->where('id', '!=', $adSlot->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $adSlot->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'exhibition' => $validated['exhibition'],
            'description' => $validated['description'] ?? null,
            'sorting' => $validated['sorting'] ?? 0,
            'active' => $request->boolean('active'),
        ]);

        /*
        * Atualiza os tenants autorizados.
        *
        * O sync() adiciona os novos, mantém os existentes
        * e remove os que foram desmarcados.
        */
        $adSlot->tenants()->sync(
            $validated['tenant_ids'] ?? []
        );

        return redirect()
            ->route('admin.dashboard.adSlot.index')
            ->with(
                'success',
                'Espaço de anúncio atualizado com sucesso.'
            );
    }

    public function destroy(
        AdSlot $adSlot,
        ThemeManager $themeManager
    ) {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'ad_slot',
            'anuncios.excluir',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $themeData = $themeManager->theme();

        $this->ensureBelongsToCurrentTheme(
            $adSlot,
            $themeData->id
        );

        /*
         * Impede a exclusão caso o espaço ainda esteja
         * vinculado a algum anúncio.
         */
        if ($adSlot->announcements()->exists()) {
            return redirect()
                ->route('admin.dashboard.adSlot.index')
                ->with(
                    'error',
                    'Este espaço de anúncio possui anúncios vinculados e não pode ser excluído.'
                );
        }

        $adSlot->delete();

        return redirect()
            ->route('admin.dashboard.adSlot.index')
            ->with(
                'success',
                'Espaço de anúncio excluído com sucesso.'
            );
    }

    /**
     * Garante que o AdSlot pertence ao template atualmente selecionado.
     */
    protected function ensureBelongsToCurrentTheme(
        AdSlot $adSlot,
        int $templateThemeId
    ): void {
        abort_unless(
            (int) $adSlot->template_theme_id === (int) $templateThemeId,
            404
        );
    }
}