<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ServiceItem;
use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceItemController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/services/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'slides' → é o módulo definido no template_modules.php.
        // 'slide.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('services', 'servicos.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; 
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $serviceItems = ServiceItem::get();
        $serviceItemLimit = $themeManager->getLimit('services', 0);
        $serviceSection = ServiceSection::whereIn('section', ['service', 'gallery'])
        ->get()
        ->keyBy('section');
        
        return view('admin.blades.serviceItems.index',compact('serviceItems','serviceSection', 'serviceItemLimit', 'theme', 'themeData'));
    }


    public function store(Request $request, ThemeManager $themeManager)
    {
        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
            'path_icon' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        $limit = $themeManager->getLimit('services', 0);
        $currentCount = ServiceItem::count();

        if ($limit !== null && $currentCount >= $limit) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'limit' => "O limite de {$limit} serviços foi atingido."
                ]);
        }

        $data = $request->except([
            'path_image',
            'path_icon'
        ]);

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

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

        if ($request->hasFile('path_icon')) {
            $fileIcon = $request->file('path_icon');

            $mimeIcon = $fileIcon->getMimeType();

            if ($mimeIcon === 'image/svg+xml') {
                $filenameIcon = pathinfo(
                    $fileIcon->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $fileIcon,
                    $filenameIcon
                );
            } else {
                $filenameIcon = pathinfo(
                    $fileIcon->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.avif';

                $imageIcon = $manager
                    ->read($fileIcon)
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::put(
                    $pathUpload . $filenameIcon,
                    $imageIcon
                );
            }

            $data['path_icon'] = $pathUpload . $filenameIcon;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();

            ServiceItem::create($data);

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

    public function update(Request $request, ServiceItem $serviceItem)
    {
        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
            'path_icon' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        $data = $request->except([
            'path_image',
            'path_icon'
        ]);

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

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

            if (!empty($serviceItem->path_image)) {
                Storage::delete(
                    $serviceItem->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if ($request->hasFile('path_icon')) {
            $fileIcon = $request->file('path_icon');

            $mimeIcon = $fileIcon->getMimeType();

            if ($mimeIcon === 'image/svg+xml') {
                $filenameIcon = pathinfo(
                    $fileIcon->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $fileIcon,
                    $filenameIcon
                );
            } else {
                $filenameIcon = pathinfo(
                    $fileIcon->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.avif';

                $imageIcon = $manager
                    ->read($fileIcon)
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::put(
                    $pathUpload . $filenameIcon,
                    $imageIcon
                );
            }

            if (!empty($serviceItem->path_icon)) {
                Storage::delete(
                    $serviceItem->path_icon
                );
            }

            $data['path_icon'] = $pathUpload . $filenameIcon;
        }

        if ($request->has('delete_path_image')) {
            if (
                !empty($serviceItem->path_image) &&
                Storage::exists($serviceItem->path_image)
            ) {
                Storage::delete(
                    $serviceItem->path_image
                );
            }

            $data['path_image'] = null;
        }

        if ($request->has('delete_path_icon')) {
            if (
                !empty($serviceItem->path_icon) &&
                Storage::exists($serviceItem->path_icon)
            ) {
                Storage::delete(
                    $serviceItem->path_icon
                );
            }

            $data['path_icon'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();

            $serviceItem->fill($data)->save();

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
    public function destroy(ServiceItem $serviceItem)
    {
        Storage::delete(isset($serviceItem->path_image)??$serviceItem->path_image);
        Storage::delete(isset($serviceItem->path_icon)??$serviceItem->path_icon);
        $serviceItem->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {
        foreach ($request->deleteAll as $serviceItemId) {
            $serviceItem = ServiceItem::find($serviceItemId);

            if ($serviceItem) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($serviceItem)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $serviceItemId,
                            'title' => $serviceItem->title,
                            'description' => $serviceItem->description,
                            'text' => $serviceItem->text,
                            'path_image' => $serviceItem->path_image,
                            'path_icon' => $serviceItem->path_icon,
                            'link' => $serviceItem->link,
                            'scroll_section' => $serviceItem->scroll_section,
                            'active' => $serviceItem->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $serviceItemId não encontrado.");
            }
        }

        $deleted = ServiceItem::whereIn('id', $request->deleteAll)->delete();

        if ($deleted) {
            return Response::json([
                'status' => 'success',
                'message' => $deleted . ' ' . __('dashboard.response_item_delete')
            ]);
        }

        return Response::json([
            'status' => 'error',
            'message' => 'Nenhum item foi deletado.'
        ], 500);
    }

    public function sorting(Request $request)
    {
        foreach ($request->arrId as $sorting => $id) {
            $serviceItem = ServiceItem::find($id);

            if ($serviceItem) {
                $serviceItem->sorting = $sorting;
                $serviceItem->save();

                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($serviceItem)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $serviceItem->title,
                            'description' => $serviceItem->description,
                            'text' => $serviceItem->text,
                            'path_image' => $serviceItem->path_image,
                            'path_icon' => $serviceItem->path_icon,
                            'link' => $serviceItem->link,
                            'scroll_section' => $serviceItem->scroll_section,
                            'active' => $serviceItem->active,
                            'sorting' => $serviceItem->sorting,
                            'event' => 'order_updated',
                        ]
                    ])
                    ->log('order_updated');
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }
        }

        return Response::json([
            'status' => 'success'
        ]);
    }
}
