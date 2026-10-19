<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\TemplateTheme;
use App\Models\Tenant;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class TenantController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/tenant/";
    }

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'config_theme' → é o módulo definido no template_modules.php.
        // 'configuracao do tema.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('config_theme', 'configuracao do tema.visualizar', $settingTheme);

        if ($check !== true) {
            return $check;
        }


        $tenant = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $plans = Plan::with(['moduleLimits', 'tenants'])
        ->withCount('tenants')
        ->orderBy('id', 'desc')
        ->get();        
        $availableModules = $themeManager->availableModules();
        $templateThemes = TemplateTheme::orderBy('name', 'ASC')->get();
        
        return view('admin.blades.tenant.index', compact('tenant', 'theme', 'themeData', 'plans', 'templateThemes', 'availableModules'));
    }

    public function store(Request $request, ThemeManager $themeManager)
    {
        $tenant = Tenant::current();

        if (!$tenant) {
            Alert::error('Erro', 'Tenant não encontrado.');

            return redirect()->back();
        }

        $request->validate([
            'path_image_logo_header' => ['nullable','file','image','max:2048'],
            'path_image_logo_footer' => ['nullable','file','image','max:2048'],
        ]);

        $data = $request->except([
            'path_image_logo_header',
            'path_image_logo_footer',
            'delete_path_image_logo_header',
            'delete_path_image_logo_footer',
        ]);

        $manager = new ImageManager(new ImagickDriver());

        $pathUpload = $this->getPathUpload();

        try {

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Logo Header
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('path_image_logo_header')) {

                $file = $request->file('path_image_logo_header');
                $mime = $file->getMimeType();

                $extension = strtolower(
                    $file->getClientOriginalExtension()
                );

                $isSvg = $mime === 'image/svg+xml'
                    || $extension === 'svg';

                $filename = Str::uuid()->toString()
                    . ($isSvg ? '.svg' : '.avif');

                /*
                |--------------------------------------------------------------------------
                | SVG
                |--------------------------------------------------------------------------
                */

                if ($isSvg) {

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Converter para AVIF
                    |--------------------------------------------------------------------------
                    */

                    $image = $manager
                        ->read($file)
                        ->resize(
                            null,
                            null,
                            function ($constraint) {

                                $constraint->aspectRatio();

                                $constraint->upsize();

                            }
                        )
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );

                }

                $data['path_image_logo_header'] =
                    $pathUpload . $filename;

            }

            /*
            |--------------------------------------------------------------------------
            | Logo Footer
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('path_image_logo_footer')) {

                $file = $request->file('path_image_logo_footer');
                $mime = $file->getMimeType();

                $extension = strtolower(
                    $file->getClientOriginalExtension()
                );

                $isSvg = $mime === 'image/svg+xml'
                    || $extension === 'svg';

                $filename = Str::uuid()->toString()
                    . '_footer'
                    . ($isSvg ? '.svg' : '.avif');

                /*
                |--------------------------------------------------------------------------
                | SVG
                |--------------------------------------------------------------------------
                */

                if ($isSvg) {

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Converter para AVIF
                    |--------------------------------------------------------------------------
                    */

                    $image = $manager
                        ->read($file)
                        ->resize(
                            null,
                            null,
                            function ($constraint) {

                                $constraint->aspectRatio();

                                $constraint->upsize();

                            }
                        )
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );

                }

                $data['path_image_logo_footer'] =
                    $pathUpload . $filename;

            }

            /*
            |--------------------------------------------------------------------------
            | Atualizar Tenant
            |--------------------------------------------------------------------------
            */

            $tenant->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            report($e);

            Alert::error(
                'Erro',
                __('dashboard.response_item_error_update')
            );

            return redirect()->back();

        }

        return redirect()->back();
    }

    public function update(Request $request, Tenant $tenant, ThemeManager $themeManager) {

        $tenant = Tenant::current();

        if (!$tenant) {

            Alert::error(
                'Erro',
                'Tenant não encontrado.'
            );

            return redirect()->back();

        }

        $request->validate([
            'path_image_logo_header' => ['nullable','file','image','max:2048'],
            'path_image_logo_footer' => ['nullable','file','image','max:2048'],
        ]);

        $data = $request->except([
            'path_image_logo_header',
            'path_image_logo_footer',
            'delete_path_image_logo_header',
            'delete_path_image_logo_footer',
        ]);

        $manager = new ImageManager(new ImagickDriver());

        $pathUpload = $this->getPathUpload();

        try {

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Atualizar Logo Header
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('path_image_logo_header')) {

                $file = $request->file(
                    'path_image_logo_header'
                );

                $mime = $file->getMimeType();

                $extension = strtolower(
                    $file->getClientOriginalExtension()
                );

                $isSvg = $mime === 'image/svg+xml'
                    || $extension === 'svg';

                $filename = Str::uuid()->toString()
                    . ($isSvg ? '.svg' : '.avif');

                /*
                |--------------------------------------------------------------------------
                | Salvar SVG
                |--------------------------------------------------------------------------
                */

                if ($isSvg) {

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Converter para AVIF
                    |--------------------------------------------------------------------------
                    */

                    $image = $manager
                        ->read($file)
                        ->resize(
                            null,
                            null,
                            function ($constraint) {

                                $constraint->aspectRatio();

                                $constraint->upsize();

                            }
                        )
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | Remover imagem anterior
                |--------------------------------------------------------------------------
                */

                if (
                    !empty(
                        $tenant->path_image_logo_header
                    )
                    &&
                    Storage::disk('public')->exists(
                        $tenant->path_image_logo_header
                    )
                ) {

                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_header
                    );

                }

                $data['path_image_logo_header'] =
                    $pathUpload . $filename;

            }

            /*
            |--------------------------------------------------------------------------
            | Remover Logo Header
            |--------------------------------------------------------------------------
            */

            if (
                $request->boolean(
                    'delete_path_image_logo_header'
                )
            ) {

                if (
                    !empty(
                        $tenant->path_image_logo_header
                    )
                    &&
                    Storage::disk('public')->exists(
                        $tenant->path_image_logo_header
                    )
                ) {

                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_header
                    );

                }

                $data['path_image_logo_header'] = null;

            }

            /*
            |--------------------------------------------------------------------------
            | Atualizar Logo Footer
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('path_image_logo_footer')) {

                $file = $request->file(
                    'path_image_logo_footer'
                );

                $mime = $file->getMimeType();

                $extension = strtolower(
                    $file->getClientOriginalExtension()
                );

                $isSvg = $mime === 'image/svg+xml'
                    || $extension === 'svg';

                $filename = Str::uuid()->toString()
                    . '_footer'
                    . ($isSvg ? '.svg' : '.avif');

                /*
                |--------------------------------------------------------------------------
                | Salvar SVG
                |--------------------------------------------------------------------------
                */

                if ($isSvg) {

                    Storage::disk('public')->putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Converter para AVIF
                    |--------------------------------------------------------------------------
                    */

                    $image = $manager
                        ->read($file)
                        ->resize(
                            null,
                            null,
                            function ($constraint) {

                                $constraint->aspectRatio();

                                $constraint->upsize();

                            }
                        )
                        ->toAvif(quality: 95)
                        ->toString();

                    Storage::disk('public')->put(
                        $pathUpload . $filename,
                        $image
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | Remover imagem anterior
                |--------------------------------------------------------------------------
                */

                if (
                    !empty(
                        $tenant->path_image_logo_footer
                    )
                    &&
                    Storage::disk('public')->exists(
                        $tenant->path_image_logo_footer
                    )
                ) {

                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_footer
                    );

                }

                $data['path_image_logo_footer'] =
                    $pathUpload . $filename;

            }

            /*
            |--------------------------------------------------------------------------
            | Remover Logo Footer
            |--------------------------------------------------------------------------
            */

            if (
                $request->boolean(
                    'delete_path_image_logo_footer'
                )
            ) {

                if (
                    !empty(
                        $tenant->path_image_logo_footer
                    )
                    &&
                    Storage::disk('public')->exists(
                        $tenant->path_image_logo_footer
                    )
                ) {

                    Storage::disk('public')->delete(
                        $tenant->path_image_logo_footer
                    );

                }

                $data['path_image_logo_footer'] = null;

            }

            /*
            |--------------------------------------------------------------------------
            | Atualizar Tenant
            |--------------------------------------------------------------------------
            */

            $tenant->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            report($e);

            Alert::error(
                'Erro',
                __('dashboard.response_item_error_update')
            );

            return redirect()->back();

        }

        return redirect()->back();

    }
    
    public function destroy(Tenant $tenant)
    {
        if ($tenant->path_image_logo_header) {
            Storage::delete(
                $tenant->path_image_logo_header
            );
        }

        if ($tenant->path_image_logo_footer) {
            Storage::delete(
                $tenant->path_image_logo_footer
            );
        }

        $tenant->delete();

        Session::flash(
            'success',
            __('dashboard.response_item_delete')
        );

        return redirect()->back();
    }
}