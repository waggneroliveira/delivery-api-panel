<?php

namespace App\Http\Controllers;

use App\Models\ImpactSection;
use App\Models\ImpactSectionMetric;
use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;

class ImpactSectionController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);
        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/impactSection/";
    }

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'impactSection',
            'destaques.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $serviceSection = ServiceSection::whereIn('section', ['pilar'])
        ->get()
        ->keyBy('section');
        $impactSections = ImpactSection::with('metrics')->get();

        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $impactSectionsLimit = $themeManager->getLimit('impactSection', 0);

        return view('admin.blades.impactSection.index', compact(
            'serviceSection',
            'impactSections',
            'impactSectionsLimit',
            'theme',
            'themeData'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->except([
            'path_image',
            'path_icon',
            'metrics',
        ]);

        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        /*
        |--------------------------------------------------------------------------
        | PATH ICON
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('path_icon')) {
            $file = $request->file('path_icon');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_icon'] = $pathUpload . $filename;
        }

        /*
        |--------------------------------------------------------------------------
        | PATH IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();

            $impactSection = ImpactSection::create($data);

            /*
            |--------------------------------------------------------------------------
            | MÉTRICAS
            |--------------------------------------------------------------------------
            */

            foreach ($request->input('metrics', []) as $metric) {
                if (
                    empty($metric['title']) &&
                    empty($metric['value'])
                ) {
                    continue;
                }

                $impactSection->metrics()->create([
                    'title' => $metric['title'] ?? '',
                    'value' => $metric['value'] ?? '',
                    'active' => !empty($metric['active']) ? 1 : 0,
                ]);
            }

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_create')
            );
        }

        return redirect()->back();
    }

    public function edit(ImpactSection $impactSection)
    {
        $impactSection->load('metrics');

        return view(
            'admin.blades.impactSection.edit',
            compact('impactSection')
        );
    }

    public function update(Request $request, ImpactSection $impactSection)
    {
        $data = $request->except([
            'path_image',
            'path_icon',
            'metrics',
        ]);

        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        /*
        |--------------------------------------------------------------------------
        | PATH ICON
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('path_icon')) {
            $file = $request->file('path_icon');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            if (!empty($impactSection->path_icon)) {
                Storage::delete($impactSection->path_icon);
            }

            $data['path_icon'] = $pathUpload . $filename;
        }

        if (
            $request->filled('delete_path_icon') &&
            !$request->hasFile('path_icon')
        ) {
            if (!empty($impactSection->path_icon)) {
                Storage::delete($impactSection->path_icon);
            }

            $data['path_icon'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | PATH IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            if (!empty($impactSection->path_image)) {
                Storage::delete($impactSection->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->filled('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {
            if (!empty($impactSection->path_image)) {
                Storage::delete($impactSection->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();

            $impactSection->fill($data)->save();

            /*
            |--------------------------------------------------------------------------
            | MÉTRICAS
            |--------------------------------------------------------------------------
            */

            $metricIds = [];

            foreach ($request->input('metrics', []) as $metric) {

                if (
                    empty($metric['title']) &&
                    empty($metric['value'])
                ) {
                    continue;
                }

                if (!empty($metric['id'])) {

                    $impactSectionMetric = ImpactSectionMetric::where(
                        'impact_section_id',
                        $impactSection->id
                    )->find($metric['id']);

                    if ($impactSectionMetric) {
                        $impactSectionMetric->update([
                            'title' => $metric['title'] ?? '',
                            'value' => $metric['value'] ?? '',
                            'active' => !empty($metric['active']) ? 1 : 0,
                        ]);

                        $metricIds[] = $impactSectionMetric->id;
                    }

                } else {

                    $impactSectionMetric = $impactSection->metrics()->create([
                        'title' => $metric['title'] ?? '',
                        'value' => $metric['value'] ?? '',
                        'active' => !empty($metric['active']) ? 1 : 0,
                    ]);

                    $metricIds[] = $impactSectionMetric->id;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | REMOVE MÉTRICAS EXCLUÍDAS DO FORMULÁRIO
            |--------------------------------------------------------------------------
            */

            $metricsQuery = $impactSection->metrics();

            if (!empty($metricIds)) {
                $metricsQuery->whereNotIn('id', $metricIds);
            }

            $metricsQuery->delete();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->back();
    }

    public function destroy(ImpactSection $impactSection)
    {
        DB::beginTransaction();

        try {
            Storage::delete($impactSection->path_icon);
            Storage::delete($impactSection->path_image);

            $impactSection->metrics()->delete();
            $impactSection->delete();

            DB::commit();

            Session::flash(
                'success',
                __('dashboard.response_item_delete')
            );
        } catch (\Exception $e) {
            DB::rollBack();

            Session::flash(
                'error',
                __('dashboard.response_item_error_delete')
            );
        }

        return redirect()->back();
    }
}