<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class PartnerController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/partner/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('partner', 'parceiro.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }
        $serviceSection = ServiceSection::whereIn('section', ['partners'])
        ->get()
        ->keyBy('section');
        $partners = Partner::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view('admin.blades.partner.index', compact('serviceSection', 'partners', 'theme', 'themeData'));
    }


    public function store(Request $request)
    {
        $data = $request->except(['path_image']);
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
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

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();
            Partner::create($data);
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

        return redirect()->route('admin.dashboard.partner.index');
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->except(['path_image']);
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
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

            if (!empty($partner->path_image)) {
                Storage::disk('public')->delete(
                    $partner->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->has('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {
            if (!empty($partner->path_image)) {
                Storage::disk('public')->delete(
                    $partner->path_image
                );
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();
            $partner->fill($data)->save();
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

    public function destroy(Partner $partner)
    {
        Storage::delete(isset($partner->path_image)??$partner->path_image);
        $partner->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $partnerId) {
            $partner = Partner::find($partnerId);
    
            if ($partner) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($partner)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $partnerId,
                            'path_image' => $partner->path_image,
                            'link' => $partner->link,
                            'sorting' => $partner->sorting,
                            'active' => $partner->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $partnerId não encontrado.");
            }
        }
    
        $deleted = Partner::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }


    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $partner = Partner::find($id);
    
            if ($partner) {
                $partner->sorting = $sorting;
                $partner->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($partner) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($partner)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'path_image' => $partner->path_image,
                            'link' => $partner->link,
                            'sorting' => $partner->sorting,
                            'active' => $partner->active,
                            'event' => 'order_updated',
                        ]
                    ])
                    ->log('order_updated');
            } else {
                \Log::warning("Item com ID $id não encontrado.");
            }
        }
    
        return Response::json(['status' => 'success']);
    }
}
