<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('brands', 'marcas.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $brands = Brand::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.brand.index', compact('brands', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        try {
            DB::beginTransaction();
                Brand::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();            
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);


        try {
            DB::beginTransaction();
                $brand->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

        public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $brandId) {
            $brand = Brand::find($brandId);
    
            if ($brand) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($brand)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $brandId,
                            'title' => $brand->title,
                            'slug' => $brand->slug,
                            'sorting' => $brand->sorting,
                            'active' => $brand->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $brandId não encontrado.");
            }
        }
    
        $deleted = Brand::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $brand = Brand::find($id);
    
            if ($brand) {
                $brand->sorting = $sorting;
                $brand->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($brand) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($brand)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $brand->title,
                            'slug' => $brand->slug,
                            'sorting' => $brand->sorting,
                            'active' => $brand->active,
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
