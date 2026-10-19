<?php

namespace App\Http\Controllers;

use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceSectionController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/service-section/";
    }

    public function store(Request $request)
    {
        $data = $request->except('path_image');
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        $data['active'] = $request->active ? 1 : 0;

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        try {
            DB::beginTransaction();

            ServiceSection::create($data);

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

    public function update(Request $request, ServiceSection $serviceSection)
    {
        $data = $request->except('path_image');
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        $data['active'] = $request->active ? 1 : 0;

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            if (!empty($serviceSection->path_image)) {
                Storage::delete(
                    $serviceSection->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if ($request->has('delete_path_image')) {
            if (
                !empty($serviceSection->path_image) &&
                Storage::exists($serviceSection->path_image)
            ) {
                Storage::delete(
                    $serviceSection->path_image
                );
            }

            $data['path_image'] = null;
        }

        try {
            DB::beginTransaction();

            $serviceSection->fill($data)->save();

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceSection $serviceSection)
    {
        Storage::delete(isset($serviceSection->path_image)??$serviceSection->path_image);
        $serviceSection->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
