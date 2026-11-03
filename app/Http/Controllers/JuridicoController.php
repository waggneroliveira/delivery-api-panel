<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Juridico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;
use App\Http\Controllers\Helpers\HelperArchive;

class JuridicoController extends Controller
{
    protected $pathUpload = 'admin/uploads/files/juridico/';
    public function index()
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') &&
          !Auth::user()->hasPermissionTo('juridico.visualizar')){
            return view('admin.error.403', compact('settingTheme'));
        }
        $juridicos = Juridico::sorting()->get();
       
        return view('admin.blades.juridico.index', compact('juridicos'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $helper = new HelperArchive();

        $path_file = $helper->renameArchiveUpload($request, 'path_file');
        if ($path_file) {
            $data['path_file'] = $this->pathUpload . $path_file;
        }
        if ($path_file) {
            $request->file('path_file')->storeAs($this->pathUpload, $path_file);
        }

        try {
            DB::beginTransaction();
                if(!Juridico::create($data)){                    
                    Storage::delete($this->pathUpload . $path_file);
                    throw new Exception();
                }
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Juridico $juridico)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $helper = new HelperArchive();

        $path_file = $helper->renameArchiveUpload($request, 'path_file');
        if ($path_file) {
            $data['path_file'] = $this->pathUpload . $path_file;
        }
        if ($path_file) {
            $request->file('path_file')->storeAs($this->pathUpload, $path_file);
            Storage::delete($juridico->path_file?$juridico->path_file:'');
        }
        if(isset($request->delete_path_file) && !$path_file){
            $inputFile = $request->delete_path_file;
            Storage::delete($juridico->$inputFile);
            $data['path_file'] = null;
        }

        try {
            DB::beginTransaction();
                $juridico->fill($data)->save();
                if ($path_file) {
                    Storage::delete($this->pathUpload . $path_file);
                }
                if ($path_file) {
                    $request->file('path_file')->storeAs($this->pathUpload, $path_file);
                }
                DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(Juridico $juridico)
    {
        Storage::delete(isset($juridico->path_file)??$juridico->path_file);
        $juridico->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

        public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $juridicoId) {
            $juridico = Juridico::find($juridicoId);
    
            if ($juridico) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($juridico)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $juridicoId,
                            'title' => $juridico->title,
                            'link' => $juridico->link,
                            'legal' => $juridico->legal,
                            'region' => $juridico->region,
                            'description' => $juridico->description,
                            'path_file' => $juridico->path_file,
                            'sorting' => $juridico->sorting,
                            'active' => $juridico->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $juridicoId não encontrado.");
            }
        }
    
        $deleted = Juridico::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $juridico = Juridico::find($id);
    
            if ($juridico) {
                $juridico->sorting = $sorting;
                $juridico->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($juridico) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($juridico)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $juridico->title,
                            'link' => $juridico->link,
                            'legal' => $juridico->legal,
                            'region' => $juridico->region,
                            'description' => $juridico->description,
                            'path_file' => $juridico->path_file,
                            'sorting' => $juridico->sorting,
                            'active' => $juridico->active,
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
