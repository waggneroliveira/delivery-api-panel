<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;

class RegionalController extends Controller
{

    public function index()
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') && 
          !Auth::user()->hasPermissionTo('regionais.visualizar')){
            return view('admin.error.403', compact('settingTheme'));
        }

        $regionais = Regional::sorting()->get();

        return view('admin.blades.regional.index', compact('regionais'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        try {
            DB::beginTransaction();
                Regional::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();            
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Regional $regional)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);
        try {
            DB::beginTransaction();
                $regional->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(Regional $regional)
    {
        $regional->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $regionalId) {
            $regional = Regional::find($regionalId);
    
            if ($regional) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($regional)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $regionalId,
                            'title' => $regional->title,
                            'slug' => $regional->slug,
                            'sorting' => $regional->sorting,
                            'active' => $regional->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $regionalId não encontrado.");
            }
        }
    
        $deleted = regional::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $regional = Regional::find($id);
    
            if ($regional) {
                $regional->sorting = $sorting;
                $regional->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($regional) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($regional)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $regional->title,
                            'slug' => $regional->slug,
                            'sorting' => $regional->sorting,
                            'active' => $regional->active,
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
