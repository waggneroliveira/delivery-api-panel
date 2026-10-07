<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogCategoryRequest;
use App\Http\Requests\BlogCategoryRequestUpdate;
use App\Models\BlogCategory;
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

class BlogCategoryController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/blogCategory/";
    }

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('blog_categories', 'categorias de noticias.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $blogCategories = BlogCategory::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $blogCategoriesLimit = $themeManager->getLimit('blog_categories', 0);
        return view('admin.blades.blogCategory.index', compact('blogCategories', 'blogCategoriesLimit', 'theme', 'themeData'));
    }

    public function store(BlogCategoryRequest $request)
        {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048'],
        ]);

        $data = $request->except([
            'path_image'
        ]);

        $data['active'] = $request->active ? 1 : 0;

        $data['slug'] = Str::slug($request->title);

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

        try {

            DB::beginTransaction();

            BlogCategory::create($data);

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );

            return redirect()->back();

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error(
                'error',
                __('dashboard.response_item_error_create')
            );

            return redirect()->back();
        }
    }

    public function update(BlogCategoryRequestUpdate $request, BlogCategory $blogCategory) {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048' ],
        ]);

    
        $data = $request->except([
            'path_image'
        ]);

        $data['active'] = $request->active ? 1 : 0;

        $data['slug'] = Str::slug($request->title);

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

            // Remove a imagem anterior somente após salvar a nova
            if (!empty($blogCategory->path_image)) {
                Storage::delete(
                    $blogCategory->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        // Remove a imagem somente se não houver novo upload
        if (
            $request->filled('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {

            if (!empty($blogCategory->path_image)) {
                Storage::delete(
                    $blogCategory->path_image
                );
            }

            $data['path_image'] = null;
        }

        try {

            DB::beginTransaction();

            $blogCategory->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

            return redirect()->back();

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error(
                'error',
                __('dashboard.response_item_error_update')
            );

            return redirect()->back();
        }

    }


    public function destroy(BlogCategory $blogCategory)
    {
        Storage::delete(isset($blogCategory->path_image)??$blogCategory->path_image);
        $blogCategory->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $blogCategoryId) {
            $blogCategory = BlogCategory::find($blogCategoryId);
    
            if ($blogCategory) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($blogCategory)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $blogCategoryId,
                            'title' => $blogCategory->title,
                            'slug' => $blogCategory->slug,
                            'sorting' => $blogCategory->sorting,
                            'active' => $blogCategory->active,
                            'path_image' => $blogCategory->path_image,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $blogCategoryId não encontrado.");
            }
        }
    
        $deleted = BlogCategory::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $blogCategory = BlogCategory::find($id);
    
            if ($blogCategory) {
                $blogCategory->sorting = $sorting;
                $blogCategory->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($blogCategory) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($blogCategory)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $blogCategory->title,
                            'slug' => $blogCategory->slug,
                            'sorting' => $blogCategory->sorting,
                            'active' => $blogCategory->active,
                            'path_image' => $blogCategory->path_image,
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
