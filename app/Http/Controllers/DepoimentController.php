<?php

namespace App\Http\Controllers;

use App\Models\Depoiment;
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

class DepoimentController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/depoiment/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'slides' → é o módulo definido no template_modules.php.
        // 'slide.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('testimonials', 'depoimento.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $depoiments = Depoiment::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $serviceSection = ServiceSection::whereIn('section', ['testimonial'])
        ->get()
        ->keyBy('section');
        return view('admin.blades.depoiment.index', compact('serviceSection', 'depoiments', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048']
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

            $data['path_image'] = $pathUpload . $filename;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            Depoiment::create($data);

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

        return redirect()->route('admin.dashboard.depoiment.index');
    }

    public function update(Request $request, Depoiment $depoiment)
    {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048']
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

            if (!empty($depoiment->path_image)) {
                Storage::delete($depoiment->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->filled('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {

            if (!empty($depoiment->path_image)) {
                Storage::delete($depoiment->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            $depoiment->fill($data)->save();

            DB::commit();

            session()->flash('success', __('dashboard.response_item_update'));

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->route('admin.dashboard.depoiment.index');

    }

    public function destroy(Depoiment $depoiment)
    {
        Storage::delete(isset($depoiment->path_image)??$depoiment->path_image);
        $depoiment->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

        public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $depoimentId) {
            $depoiment = Depoiment::find($depoimentId);
    
            if ($depoiment) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($depoiment)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $depoimentId,
                            'name' => $depoiment->name,
                            'function' => $depoiment->function,
                            'path_image' => $depoiment->path_image,
                            'text' => $depoiment->text,
                            'sorting' => $depoiment->sorting,
                            'active' => $depoiment->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $depoimentId não encontrado.");
            }
        }
    
        $deleted = Depoiment::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $depoiment = Depoiment::find($id);
    
            if ($depoiment) {
                $depoiment->sorting = $sorting;
                $depoiment->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($depoiment) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($depoiment)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'name' => $depoiment->name,
                            'function' => $depoiment->function,
                            'path_image' => $depoiment->path_image,
                            'text' => $depoiment->text,
                            'sorting' => $depoiment->sorting,
                            'active' => $depoiment->active,
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
