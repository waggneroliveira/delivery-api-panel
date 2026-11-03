<?php

namespace App\Http\Controllers;

use App\Models\Unionized;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;

class UnionizedController extends Controller
{
    protected $pathUpload = 'admin/uploads/project/file/';
    public function index()
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') && 
          !Auth::user()->hasPermissionTo('sindicalize-se.visualizar')){
            return view('admin.error.403', compact('settingTheme'));
        }

        $unionized = Unionized::first();

        return view('admin.blades.unionized.index', compact('unionized'));
    }

    
    public function store(Request $request)
    {
        $data = $request->except(['path_file']);
        $data['active'] = $request->active ? 1 : 0;

        $request->validate([
            'path_file' => ['nullable', 'file', 'mimes:pdf', 'max:3072'] // max:3072 = 3MB
        ]);

        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.pdf';

            // Salva direto no storage
            Storage::putFileAs($this->pathUpload, $file, $filename);

            $data['path_file'] = $this->pathUpload . $filename;
        }

        try {
            DB::beginTransaction();
                Unionized::create($data);
            DB::commit();

            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();            
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }

    }

    public function update(Request $request, Unionized $unionized)
    {
        $data = $request->except(['path_file']);
        $data['active'] = $request->active ? 1 : 0;

        $request->validate([
            'path_file' => ['nullable', 'file', 'mimes:pdf', 'max:3072'] // 3MB
        ]);

        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.pdf';

            // Apaga o arquivo anterior (se existir)
            if (!empty($unionized->path_file) && Storage::exists($unionized->path_file)) {
                Storage::delete($unionized->path_file);
            }

            // Salva o novo PDF
            Storage::putFileAs($this->pathUpload, $file, $filename);

            $data['path_file'] = $this->pathUpload . $filename;
        }

        // Se o usuário pediu para remover via Dropify
        if ($request->has('delete_path_file')) {
            if (!empty($unionized->path_file) && Storage::exists($unionized->path_file)) {
                Storage::delete($unionized->path_file);
            }
            $data['path_file'] = null;
        }

        try {
            DB::beginTransaction();
                $unionized->fill($data)->save();
            DB::commit();

            session()->flash('success', __('dashboard.response_item_update'));
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
        }
        return redirect()->back();
    }

    public function destroy(Unionized $unionized)
    {
        Storage::delete(isset($unionized->path_file)??$unionized->path_file);
        $unionized->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
