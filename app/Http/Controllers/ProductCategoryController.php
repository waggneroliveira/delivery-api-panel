<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
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

class ProductCategoryController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/product-category/";
    }

    public function index(Request $request, ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('product_categories', 'categorias de produtos.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }
    
        $blogCategories = productCategory::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.productCategory.index', compact('blogCategories', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['path_image']);
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        $data['active'] = $request->boolean('active');
        $data['highlight'] = $request->boolean('highlight');
        $data['slug'] = Str::slug($request->title);

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

        try {
            DB::beginTransaction();
            ProductCategory::create($data);
            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );
        } catch (\Exception $e) {
            DB::rollBack();

            Alert::error(
                'error',
                __('dashboard.response_item_error_create')
            );
        }

        return redirect()->back();
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $data = $request->except(['path_image']);
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        $data['active'] = $request->boolean('active');
        $data['highlight'] = $request->boolean('highlight');
        $data['slug'] = Str::slug($request->title);

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

            if (!empty($productCategory->path_image)) {
                Storage::disk('public')->delete(
                    $productCategory->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        if (
            $request->has('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {
            if (!empty($productCategory->path_image)) {
                Storage::disk('public')->delete(
                    $productCategory->path_image
                );
            }

            $data['path_image'] = null;
        }

        try {
            DB::beginTransaction();
            $productCategory->fill($data)->save();
            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );
        } catch (\Exception $e) {
            DB::rollBack();

            Alert::error(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->back();
    }

    public function destroy(ProductCategory $productCategory)
    {
        Storage::delete(isset($productCategory->path_image)??$productCategory->path_image);
        $productCategory->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $productCategoryId) {
            $productCategory = ProductCategory::find($productCategoryId);
    
            if ($productCategory) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($productCategory)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $productCategoryId,
                            'title' => $productCategory->title,
                            'slug' => $productCategory->slug,
                            'sorting' => $productCategory->sorting,
                            'active' => $productCategory->active,
                            'path_image' => $productCategory->path_image,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $productCategoryId não encontrado.");
            }
        }
    
        $deleted = ProductCategory::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $productCategory = ProductCategory::find($id);
    
            if ($productCategory) {
                $productCategory->sorting = $sorting;
                $productCategory->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($productCategory) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($productCategory)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $productCategory->title,
                            'slug' => $productCategory->slug,
                            'sorting' => $productCategory->sorting,
                            'active' => $productCategory->active,
                            'path_image' => $productCategory->path_image,
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
