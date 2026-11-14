<?php

namespace App\Http\Controllers;

use App\Models\ServiceLocation;
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

class ServiceLocationController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/service-location/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('service_locations', 'onde atendemos.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $serviceLocation = serviceLocation::first();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.serviceLocation.index', compact('serviceLocation', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'neighborhoods' => ['nullable', 'array'],
            'neighborhoods.*.name' => ['required', 'string', 'max:255'],
            'neighborhoods.*.delivery_fee' => ['required', 'numeric', 'min:0'],
        ]);

        $data = $request->except(['path_image']);
        $data['neighborhoods'] = array_values(array_map(
            static fn (array $neighborhood) => [
                'name' => trim($neighborhood['name']),
                'delivery_fee' => (float) $neighborhood['delivery_fee'],
            ],
            $validated['neighborhoods'] ?? []
        ));
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        
        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
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

            $data['path_image'] = $pathUpload . $filename;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();

            ServiceLocation::create($data);

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

    public function update(Request $request, ServiceLocation $serviceLocation)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'neighborhoods' => ['nullable', 'array'],
            'neighborhoods.*.name' => ['required', 'string', 'max:255'],
            'neighborhoods.*.delivery_fee' => ['required', 'numeric', 'min:0'],
        ]);

        $data = $request->except('path_image');
        $data['neighborhoods'] = array_values(array_map(
            static fn (array $neighborhood) => [
                'name' => trim($neighborhood['name']),
                'delivery_fee' => (float) $neighborhood['delivery_fee'],
            ],
            $validated['neighborhoods'] ?? []
        ));
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        
        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
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

            if (!empty($serviceLocation->path_image)) {
                Storage::disk('public')->delete(
                    $serviceLocation->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if ($request->has('delete_path_image') && !$request->hasFile('path_image')) {
            if (!empty($serviceLocation->path_image)) {
                Storage::disk('public')->delete(
                    $serviceLocation->path_image
                );
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();

            $serviceLocation->fill($data)->save();

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
    public function destroy(ServiceLocation $serviceLocation)
    {
        Storage::delete(isset($serviceLocation->path_image)??$serviceLocation->path_image);
        $serviceLocation->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
