<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogSubcategory;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BlogSubcategoryController extends Controller
{
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        $blogCategories = BlogCategory::sorting()->get();
        $blogSubCategories = BlogSubcategory::with('category')
            ->orderBy('order')
            ->orderBy('name')
            ->get();
        $blogCategory = [];
        foreach ($blogCategories as $category) {
            $blogCategory[$category->id] = $category->title;
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $blogSubCategoriesLimit = $themeManager->getLimit('blog_categories', 0);

        
        return view('admin.blades.blogSubCategory.index', compact('blogCategory', 'blogCategories', 'blogSubCategories', 'theme', 'themeData', 'blogSubCategoriesLimit'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->name    );

        try {
            DB::beginTransaction();
                BlogSubcategory::create($data);
            DB::commit();
            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error(
                'error',
                __('dashboard.response_item_error_create')
            );
            return redirect()->back();
        }

    }

    public function update(Request $request, BlogSubcategory $blogSubCategory)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->name    );

        try {
            DB::beginTransaction();
                $blogSubCategory->fill($data)->save();
            DB::commit();
            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error(
                'error',
                __('dashboard.response_item_error_update')
            );
            return redirect()->back();
        }
    }

    public function destroy(BlogSubcategory $blogSubCategory)
    {
        $blogSubCategory->delete();

        return redirect()
            ->route('admin.dashboard.blogSubCategory.index')
            ->with('success', 'Subcategoria excluída com sucesso.');
    }
}