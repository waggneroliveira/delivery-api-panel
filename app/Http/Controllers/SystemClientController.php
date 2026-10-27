<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanModuleLimit;
use App\Models\TemplateTheme;
use App\Models\Tenant;
use App\Models\TenantModuleLimit;
use App\Models\User;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class SystemClientController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/tenant/";
    }
    public function index(Request $request, ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $user = Auth::user()->hasRole('Super');

        if (!$user) {
            return view('admin.error.403', compact('settingTheme'));
        }

        $clients = Tenant::query()
            ->with('plan')
            ->orderBy('name', 'asc')
            ->paginate(20);

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view('admin.blades.client-of-system.index', compact(
            'clients',
            'theme',
            'themeData'
        ));
    }

    public function create(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $user = Auth::user()->hasRole('Super');

        if (!$user) {
            return view('admin.error.403', compact('settingTheme'));
        }

        $plans = Plan::where('active', true)->get();
        $availableModules = $themeManager->availableModules();

        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $templateThemes = TemplateTheme::orderBy('name', 'ASC')->get();
        return view('admin.blades.client-of-system.create', compact(
            'plans',
            'availableModules',
            'theme',
            'themeData',
            'templateThemes',
        ));
    }


    public function store(Request $request)
    {
        $data = $request->except([
        'path_image_logo_header',
        'path_image_logo_footer',
        ]);


        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $data['cnpj'] = !empty($data['cnpj'])
            ? preg_replace('/\D/', '', $data['cnpj'])
            : null;

        $data['slug'] = Str::slug($request->name);

        if ($data['text_button_one'] == null) {
            $data['text_button_one'] = 'Saiba mais';
        }

        if ($data['text_button_two'] == null) {
            $data['text_button_two'] = 'Saiba mais';
        }
        $data['active'] = $request->boolean('active', true);

        DB::beginTransaction();

        try {
            if ($request->hasFile('path_image_logo_header')) {
                $file = $request->file('path_image_logo_header');
                $mime = $file->getMimeType();
                $extension = strtolower($file->getClientOriginalExtension());

                if ($mime === 'image/svg+xml' || $extension === 'svg') {
                    $filename = Str::uuid() . '.svg';

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );
                } else {
                    $filename = Str::uuid() . '.avif';

                    $image = $manager
                        ->read($file)
                        ->resize(null, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );
                }

                $data['path_image_logo_header'] = $pathUpload . $filename;
            }

            if ($request->hasFile('path_image_logo_footer')) {
                $file = $request->file('path_image_logo_footer');
                $mime = $file->getMimeType();
                $extension = strtolower($file->getClientOriginalExtension());

                if ($mime === 'image/svg+xml' || $extension === 'svg') {
                    $filename = Str::uuid() . '_footer.svg';

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );
                } else {
                    $filename = Str::uuid() . '_footer.avif';

                    $image = $manager
                        ->read($file)
                        ->resize(null, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );
                }

                $data['path_image_logo_footer'] = $pathUpload . $filename;
            }

            $tenant = new Tenant();

            $tenant->fill($data);
            $tenant->save();

            foreach ($data['limits'] ?? [] as $module => $limit) {
                if ($limit === null || $limit === '') {
                    continue;
                }

                TenantModuleLimit::updateOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'module' => $module,
                    ],
                    [
                        'limit' => (int) $limit,
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('admin.dashboard.tenants.index')
                ->with('success', 'Cliente criado com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();

            Alert::error(
                'Erro',
                __('dashboard.response_item_error_create')
            );

            return redirect()->back();
        }

    }

    public function show(Tenant $tenant, ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $user = Auth::user()->hasRole('Super');

        if (!$user) {
            return view('admin.error.403', compact('settingTheme'));
        }

        $tenant->load('plan');

        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $templateThemes = TemplateTheme::orderBy('name', 'ASC')->first();
        return view('admin.blades.client-of-system.show', compact(
            'tenant',
            'theme',
            'themeData',
            'templateThemes',
        ));
    }

    public function edit(Tenant $tenant, ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $user = Auth::user()->hasRole('Super');

        if (!$user) {
            return view('admin.error.403', compact('settingTheme'));
        }

        $plans = Plan::where('active', true)->get();

        $availableModules = $themeManager->availableModules();

        $tenantModuleLimits = TenantModuleLimit::where('tenant_id', $tenant->id)
            ->get()
            ->keyBy('module');

        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $templateThemes = TemplateTheme::orderBy('name', 'ASC')->get();

        return view('admin.blades.client-of-system.edit', compact(
            'tenant',
            'plans',
            'availableModules',
            'tenantModuleLimits',
            'theme',
            'themeData',
            'templateThemes'
        ));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $data = $request->except([
            'path_image_logo_header',
            'path_image_logo_footer',
            'delete_path_image_logo_header',
            'delete_path_image_logo_footer',
        ]);

        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Remover logo do Header
            |--------------------------------------------------------------------------
            */

            if ($request->has('delete_path_image_logo_header')) {
                if (!empty($tenant->path_image_logo_header)) {
                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_header
                    );
                }

                $data['path_image_logo_header'] = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Upload logo do Header
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('path_image_logo_header')) {
                $file = $request->file('path_image_logo_header');

                $mime = $file->getMimeType();
                $extension = strtolower($file->getClientOriginalExtension());

                if ($mime === 'image/svg+xml' || $extension === 'svg') {
                    $filename = Str::uuid() . '.svg';

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );
                } else {
                    $filename = Str::uuid() . '.avif';

                    $image = $manager
                        ->read($file)
                        ->resize(null, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );
                }

                if (!empty($tenant->path_image_logo_header)) {
                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_header
                    );
                }

                $data['path_image_logo_header'] = $pathUpload . $filename;
            }

            /*
            |--------------------------------------------------------------------------
            | Remover logo do Footer
            |--------------------------------------------------------------------------
            */

            if ($request->has('delete_path_image_logo_footer')) {
                if (!empty($tenant->path_image_logo_footer)) {
                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_footer
                    );
                }

                $data['path_image_logo_footer'] = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Upload logo do Footer
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('path_image_logo_footer')) {
                $file = $request->file('path_image_logo_footer');

                $mime = $file->getMimeType();
                $extension = strtolower($file->getClientOriginalExtension());

                if ($mime === 'image/svg+xml' || $extension === 'svg') {
                    $filename = Str::uuid() . '_footer.svg';

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );
                } else {
                    $filename = Str::uuid() . '_footer.avif';

                    $image = $manager
                        ->read($file)
                        ->resize(null, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );
                }

                if (!empty($tenant->path_image_logo_footer)) {
                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_footer
                    );
                }

                $data['path_image_logo_footer'] = $pathUpload . $filename;
            }

            /*
            |--------------------------------------------------------------------------
            | Dados do Tenant
            |--------------------------------------------------------------------------
            */

            $data['cnpj'] = !empty($data['cnpj'])
                ? preg_replace('/\D/', '', $data['cnpj'])
                : null;

            $data['slug'] = Str::slug($request->name);

            if (empty($data['text_button_one'])) {
                $data['text_button_one'] = 'Saiba mais';
            }

            if (empty($data['text_button_two'])) {
                $data['text_button_two'] = 'Saiba mais';
            }

            $data['active'] = $request->boolean('active');

            $tenant->fill($data)->save();

            /*
            |--------------------------------------------------------------------------
            | Atualiza usuários
            |--------------------------------------------------------------------------
            */

            User::where('tenant_id', $tenant->id)->update([
                'active' => $tenant->active,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Limites dos módulos
            |--------------------------------------------------------------------------
            */

            foreach ($data['limits'] ?? [] as $module => $limit) {
                if ($limit === null || $limit === '') {
                    continue;
                }

                TenantModuleLimit::updateOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'module' => $module,
                    ],
                    [
                        'limit' => (int) $limit,
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('admin.dashboard.tenants.index')
                ->with('success', 'Cliente atualizado com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            Alert::error(
                'Erro',
                __('dashboard.response_item_error_update')
            );

            return redirect()->back();
        }
    }

    public function destroy(Tenant $tenant)
    {
        DB::transaction(function () use ($tenant) {
            TenantModuleLimit::where('tenant_id', $tenant->id)->delete();
            $tenant->delete();
        });

        return redirect()
            ->route('admin.dashboard.tenants.index')
            ->with('success', 'Cliente excluído com sucesso.');
    }
}

