<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Municipality;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;

class MunicipalityController extends Controller
{

    // public function index()
    // {
    //     $settingTheme = (new SettingThemeRepository())->settingTheme();
    //     if(!Auth::user()->hasRole('Super') && 
    //       !Auth::user()->can('usuario.tornar usuario master') && 
    //       !Auth::user()->hasPermissionTo('municipios.visualizar')){
    //         return view('admin.error.403', compact('settingTheme'));
    //     }

    //     $regionais = Regional::active()->sorting()->get();
    //     $municipalities = Municipality::with([
    //         'regional',
    //     ])->sorting()->paginate(50);

    //     $regionalCategory = [];

    //     foreach ($regionais as $regional) {
    //         $regionalCategory[$regional->id] = $regional->title;
    //     }

    //     return view('admin.blades.municipality.index', compact('municipalities', 'regionais', 'regionalCategory'));
    // }
public function index()
{
    $settingTheme = (new SettingThemeRepository())->settingTheme();

    // Verificação de permissões
    if (!Auth::user()->hasRole('Super') && 
        !Auth::user()->can('usuario.tornar usuario master') && 
        !Auth::user()->hasPermissionTo('municipios.visualizar')) {
        return view('admin.error.403', compact('settingTheme'));
    }

    // Buscar regionais ativas
    $regionais = Regional::active()->sorting()->get();

    // Início da query dos municípios
    $query = Municipality::with(['regional'])->sorting();

    // Aplicar filtros
    if ($title = request('title')) {
        $query->where('title', 'like', "%{$title}%");
    }

    if ($regionalId = request('regional_id')) {
        $query->where('regional_id', $regionalId);
    }

    // Paginar resultados
    $municipalities = $query->paginate(50)->withQueryString();

    // Array de regionais para select
    $regionalCategory = $regionais->pluck('title', 'id')->toArray();

    return view('admin.blades.municipality.index', compact('municipalities', 'regionais', 'regionalCategory'));
}


    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active?1:0;

        try {
            DB::beginTransaction();
                Municipality::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Municipality $municipality)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['active'] = $request->active?1:0;

        try {
            DB::beginTransaction();
                $municipality->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

        public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $municipalityId) {
            $municipality = Municipality::find($municipalityId);
    
            if ($municipality) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($municipality)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $municipalityId,
                            'regional_id' => $municipality->regional_id,
                            'title' => $municipality->title,
                            'slug' => $municipality->slug,
                            'sorting' => $municipality->sorting,
                            'active' => $municipality->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $municipalityId não encontrado.");
            }
        }
    
        $deleted = Municipality::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $municipality = Municipality::find($id);
    
            if ($municipality) {
                $municipality->sorting = $sorting;
                $municipality->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($municipality) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($municipality)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'regional_id' => $municipality->regional_id,
                            'title' => $municipality->title,
                            'slug' => $municipality->slug,
                            'sorting' => $municipality->sorting,
                            'active' => $municipality->active,
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
