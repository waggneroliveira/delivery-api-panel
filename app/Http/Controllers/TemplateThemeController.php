<?php

namespace App\Http\Controllers;

use App\Models\TemplateTheme;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;

class TemplateThemeController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/template-theme/";
    }

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $templateThemes = TemplateTheme::orderBy('name', 'asc')->get();

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view('admin.blades.templateTheme.index', compact(
                'templateThemes',
                'settingTheme',
                'theme',
                'themeData'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->all();
        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(
            new ImagickDriver()
        );

        try {

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Preview
            |--------------------------------------------------------------------------
            */

            $preview = [];

            if ($request->hasFile('preview')) {

                foreach ($request->file('preview') as $file) {

                    $filename = Str::uuid()->toString() . '.avif';

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

                    $preview[] = $pathUpload . $filename;
                }
            }

            $data['preview'] = $preview;
            $data['slug'] = Str::slug($request->name);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $data['active'] = $request->boolean('active')
                ? 1
                : 0;

            /*
            |--------------------------------------------------------------------------
            | Criar registro
            |--------------------------------------------------------------------------
            */

            TemplateTheme::create($data);

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            report($e);

            session()->flash(
                'error',
                __('dashboard.response_item_error_create')
            );
        }

        return redirect()->back();
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update( Request $request, TemplateTheme $templateTheme) {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(
            new ImagickDriver()
        );

        try {
            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Preview atual
            |--------------------------------------------------------------------------
            */

            $preview = $templateTheme->preview ?? [];

            if (!is_array($preview)) {
                $preview = [];
            }

            /*
            |--------------------------------------------------------------------------
            | Remover previews selecionados
            |--------------------------------------------------------------------------
            |
            | O formulário envia:
            |
            | delete_preview[]
            |
            */

            if ($request->has('delete_preview')) {

                $deletePreview = $request->input(
                    'delete_preview',
                    []
                );

                if (is_array($deletePreview)) {

                    foreach ($deletePreview as $imagePath) {

                        if (!in_array($imagePath, $preview, true)) {
                            continue;
                        }

                        /*
                        | Remove o arquivo físico
                        */
                        if (
                            Storage::disk('public')->exists(
                                $imagePath
                            )
                        ) {
                            Storage::disk('public')->delete(
                                $imagePath
                            );
                        }

                        /*
                        | Remove a imagem do array
                        */
                        $preview = array_values(
                            array_filter(
                                $preview,
                                fn ($path) => $path !== $imagePath
                            )
                        );
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Adicionar novos previews
            |--------------------------------------------------------------------------
            |
            | As novas imagens são convertidas para AVIF e adicionadas
            | ao array existente.
            |
            */

            if ($request->hasFile('preview')) {

                foreach ($request->file('preview') as $file) {

                    if (!$file->isValid()) {
                        continue;
                    }

                    $filename = Str::uuid()->toString() . '.avif';

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

                    $preview[] = $pathUpload . $filename;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Preview
            |--------------------------------------------------------------------------
            */

            $data['preview'] = array_values($preview);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $data['active'] = $request->boolean('active')
                ? 1
                : 0;

            /*
            |--------------------------------------------------------------------------
            | Atualizar registro
            |--------------------------------------------------------------------------
            */
            // dd($data);
            $templateTheme
                ->fill($data)
                ->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

        } catch (Exception $e) {

            DB::rollBack();

            report($e);

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(TemplateTheme $templateTheme)
    {
        /*
        |--------------------------------------------------------------------------
        | Remover previews
        |--------------------------------------------------------------------------
        */

        if (
            is_array($templateTheme->preview)
        ) {

            foreach (
                $templateTheme->preview as $imagePath
            ) {

                if (
                    !empty($imagePath)
                    &&
                    Storage::disk('public')->exists(
                        $imagePath
                    )
                ) {

                    Storage::disk('public')->delete(
                        $imagePath
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Remover Logo Header
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $templateTheme->path_image_logo_header
            )
            &&
            Storage::disk('public')->exists(
                $templateTheme->path_image_logo_header
            )
        ) {

            Storage::disk('public')->delete(
                $templateTheme->path_image_logo_header
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remover Logo Footer
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $templateTheme->path_image_logo_footer
            )
            &&
            Storage::disk('public')->exists(
                $templateTheme->path_image_logo_footer
            )
        ) {

            Storage::disk('public')->delete(
                $templateTheme->path_image_logo_footer
            );
        }

        $templateTheme->delete();

        Session::flash(
            'success',
            __('dashboard.response_item_delete')
        );

        return redirect()->back();
    }
}