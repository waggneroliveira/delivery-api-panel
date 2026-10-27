<?php

namespace App\Http\Controllers;

use App\Models\PlanNetworkCategory;
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

class PlanNetworkCategoryController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/plan-network-category/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'planNetwork' → é o módulo definido no template_modules.php.
        // 'plano.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('planNetworkCategory', 'categorias do plano.visualizar', $settingTheme);
        
        if ($check !== true) {
            return $check;
        }
        
        $planNetworkCategories = PlanNetworkCategory::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $planNetworkCategoryLimit = $themeManager->getLimit('planNetworkCategory', 0);
        
        return view('admin.blades.planNetworkCategory.index', compact('theme', 'themeData', 'planNetworkCategoryLimit', 'planNetworkCategories'));
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
                Storage::disk('public')->putFileAs($pathUpload, $file, $filename);
            } else {
                $filename = Str::uuid() . '.avif';
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::disk('public')->put($pathUpload . $filename, $image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        $data['active'] = $request->boolean('active');
        $data['slug'] = Str::slug($request->title);

        try {
            DB::beginTransaction();
            PlanNetworkCategory::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('dashboard.response_item_error_create'));
        }

        return redirect()->back();
    }

    public function update(Request $request, PlanNetworkCategory $planNetworkCategory)
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
                Storage::disk('public')->putFileAs($pathUpload, $file, $filename);
            } else {
                $filename = Str::uuid() . '.avif';
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::disk('public')->put($pathUpload . $filename, $image);
            }

            if (!empty($planNetworkCategory->path_image)) {
                Storage::disk('public')->delete($planNetworkCategory->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if ($request->filled('delete_path_image') && !$request->hasFile('path_image')) {
            if (!empty($planNetworkCategory->path_image)) {
                Storage::disk('public')->delete($planNetworkCategory->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->boolean('active');
        $data['slug'] = Str::slug($request->title);

        try {
            DB::beginTransaction();
            $planNetworkCategory->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('dashboard.response_item_error_update'));
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanNetworkCategory $planNetworkCategory)
    {
        Storage::delete(isset($planNetworkCategory->path_image)??$planNetworkCategory->path_image);
        $planNetworkCategory->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

       public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $planNetworkCategoryId) {
            $planNetworkCategory = PlanNetworkCategory::find($planNetworkCategoryId);
    
            if ($planNetworkCategory) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($planNetworkCategory)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $planNetworkCategoryId,
                            'path_image' => $planNetworkCategory->path_image,
                            'link' => $planNetworkCategory->link,
                            'sorting' => $planNetworkCategory->sorting,
                            'active' => $planNetworkCategory->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $planNetworkCategoryId não encontrado.");
            }
        }
    
        $deleted = PlanNetworkCategory::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $planNetworkCategory = PlanNetworkCategory::find($id);
    
            if ($planNetworkCategory) {
                $planNetworkCategory->sorting = $sorting;
                $planNetworkCategory->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($planNetworkCategory) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($planNetworkCategory)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'path_image' => $planNetworkCategory->path_image,
                            'link' => $planNetworkCategory->link,
                            'sorting' => $planNetworkCategory->sorting,
                            'active' => $planNetworkCategory->active,
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
