<?php

namespace App\Http\Controllers;

use App\Models\Letsgo;
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

class LetsgoController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/letsgo/";
    }

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('letsgo', 'sesssao lets go.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $letsgo = Letsgo::first();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view('admin.blades.letsgo.index', compact('letsgo', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048'],
        ]);

        $data = $request->except([
            'path_image',
        ]);

        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

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

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();
                Letsgo::create($data);
            DB::commit();

            session()->flash('success', __('dashboard.response_item_create'));

        } catch (\Exception $e) {

            DB::rollBack();
            session()->flash('error', __('dashboard.response_item_error_create'));
        }

        return redirect()->back();

    }

    public function update(Request $request, Letsgo $letsgo)
    {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048'],
        ]);

        $data = $request->except('path_image');
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

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

            if (!empty($letsgo->path_image)) {
                Storage::delete($letsgo->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->filled('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {

            if (!empty($letsgo->path_image)) {
                Storage::delete($letsgo->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();
                $letsgo->fill($data)->save();
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

    public function destroy(Letsgo $letsgo)
    {
        Storage::delete(isset($letsgo->path_image)??$letsgo->path_image);
        $letsgo->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
