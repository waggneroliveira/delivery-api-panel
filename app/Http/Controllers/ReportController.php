<?php

namespace App\Http\Controllers;

use App\Models\Report;
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

class ReportController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/report/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('mission', 'missao visao e valores.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }
        $reports = Report::get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.report.index', compact('reports', 'theme', 'themeData'));
    }


    public function store(Request $request)
    {
        $data = $request->except(['path_image', 'path_file']);
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
            'path_file' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
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

                $image = $manager->read($file)
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

            $data['path_image'] = $pathUpload . $filename;
        }

        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
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

                $image = $manager->read($file)
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

            $data['path_file'] = $pathUpload . $filename;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();

            Report::create($data);

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

    public function update(Request $request, Report $report)
    {
        $data = $request->except(['path_image', 'path_file']);
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
            'path_file' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
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

                $image = $manager->read($file)
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

            if (!empty($report->path_image)) {
                Storage::disk('public')->delete($report->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->has('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {
            if (!empty($report->path_image)) {
                Storage::disk('public')->delete($report->path_image);
            }

            $data['path_image'] = null;
        }

        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
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

                $image = $manager->read($file)
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

            if (!empty($report->path_file)) {
                Storage::disk('public')->delete($report->path_file);
            }

            $data['path_file'] = $pathUpload . $filename;
        }

        if (
            $request->has('delete_path_file') &&
            !$request->hasFile('path_file')
        ) {
            if (!empty($report->path_file)) {
                Storage::disk('public')->delete($report->path_file);
            }

            $data['path_file'] = null;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();

            $report->fill($data)->save();

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

    public function destroy(Report $report)
    {
        Storage::delete(isset($report->path_image)??$report->path_image);
        Storage::delete(isset($report->path_file)??$report->path_file);
        $report->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
