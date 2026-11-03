<?php

namespace App\Http\Controllers;

use App\Models\Statute;
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


class StatuteController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/statute/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('statute', 'passo a passo.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $statute = Statute::first();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view('admin.blades.statute.index', compact('statute', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'path_file' => ['nullable','file','image','max:3072'],
        ]);

        $data = $request->except('path_file');

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        if ($request->hasFile('path_file')) {

            $file = $request->file('path_file');

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

            $data['path_file'] = $pathUpload . $filename;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            Statute::create($data);

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

    public function update(Request $request, Statute $statute)
    {
        $request->validate([
            'path_file' => ['nullable','file','image','max:3072'],
        ]);

        $data = $request->except('path_file');
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        if ($request->hasFile('path_file')) {

            $file = $request->file('path_file');
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

            if (!empty($statute->path_file)) {

                Storage::delete(
                    $statute->path_file
                );
            }

            $data['path_file'] = $pathUpload . $filename;
        }

        if (
            $request->filled('delete_path_file') &&
            !$request->hasFile('path_file')
        ) {

            if (
                !empty($statute->path_file) &&
                Storage::exists($statute->path_file)
            ) {

                Storage::delete(
                    $statute->path_file
                );
            }

            $data['path_file'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();
                $statute->fill($data)->save();
            DB::commit();

            session()->flash('success',__('dashboard.response_item_update'));

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash('error', __('dashboard.response_item_error_update'));
        }

        return redirect()->back();
    }


    public function destroy(Statute $statute)
    {
        Storage::delete(isset($statute->path_file)??$statute->path_file);
        $statute->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
