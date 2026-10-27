<?php

namespace App\Http\Controllers;

use App\Models\Direction;
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

class DirectionController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/direction/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('representatives', 'representantes.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $directions = Direction::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.direction.index', compact('directions', 'theme', 'themeData'));
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

            Direction::create($data);

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

    public function update(Request $request, Direction $direction)
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

            if (!empty($direction->path_image)) {
                Storage::disk('public')->delete($direction->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->has('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {
            if (!empty($direction->path_image)) {
                Storage::disk('public')->delete($direction->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();

            $direction->fill($data)->save();

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

    public function destroy(Direction $direction)
    {
        Storage::delete(isset($direction->path_image)??$direction->path_image);
        $direction->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

        public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $directionId) {
            $direction = Direction::find($directionId);
    
            if ($direction) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($direction)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $directionId,
                            'title' => $direction->title,
                            'description' => $direction->description,
                            'sorting' => $direction->sorting,
                            'active' => $direction->active,
                            'event' => 'multiple_deleted',
                            'path_image' => $direction->path_image,
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $directionId não encontrado.");
            }
        }
    
        $deleted = Direction::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $direction = Direction::find($id);
    
            if ($direction) {
                $direction->sorting = $sorting;
                $direction->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($direction) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($direction)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $direction->title,
                            'description' => $direction->description,
                            'sorting' => $direction->sorting,
                            'active' => $direction->active,
                            'path_image' => $direction->path_image,
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
