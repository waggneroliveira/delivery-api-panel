<?php

namespace App\Http\Controllers;

use App\Models\PopUp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class PopUpController extends Controller
{

    protected $pathUpload = 'admin/uploads/images/pop-up/';
    public function index()
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') && 
          !Auth::user()->hasPermissionTo('anuncio.visualizar')){
            return view('admin.error.403', compact('settingTheme'));
        }

        $popUp = PopUp::first();

        return view('admin.blades.popUp.index', compact('popUp'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        $manager = new ImageManager(new ImagickDriver());

        // Imagem principal
        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();
            $filename = Str::uuid() . '.webp';

            if ($mime === 'image/svg+xml') {
                Storage::disk('public')->putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($this->pathUpload . $filename, $image);
            }

            $data['path_image'] = $this->pathUpload . $filename; 
        }

        try {
            DB::beginTransaction();
                PopUp::create($data);
            DB::commit();

            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->route('admin.dashboard.popUp.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, PopUp $popUp)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        $manager = new ImageManager(new ImagickDriver());

        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();
            $filename = Str::uuid() . '.webp';

            if ($mime === 'image/svg+xml') {
                Storage::disk('public')->putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($this->pathUpload . $filename, $image);
            }

            if (!empty($popUp->path_image)) {
                Storage::disk('public')->delete($popUp->path_image);
            }

            $data['path_image'] = $this->pathUpload . $filename; 
        }

        if ($request->has('delete_path_image')) {
            if (!empty($popUp->path_image)) {
                Storage::disk('public')->delete($popUp->path_image);
            }
            $data['path_image'] = null;
        }

        try {
            DB::beginTransaction();
                $popUp->fill($data)->save();
            DB::commit();

            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(PopUp $popUp)
    {
        Storage::delete(isset($popUp->path_image)??$popUp->path_image);
        $popUp->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
