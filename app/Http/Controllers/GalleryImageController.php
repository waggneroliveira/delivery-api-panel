<?php

namespace App\Http\Controllers;

use App\Models\ProductGallery;
use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{

    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/gallery-image/";
    }

    public function index(ThemeManager $themeManager){
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('product_gallery', 'galeria de produtos.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $galleries = ProductGallery::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $serviceSection = ServiceSection::whereIn('section', ['service', 'gallery'])
        ->get()
        ->keyBy('section');
        
        return view('admin.blades.gallery.index', compact('serviceSection', 'galleries', 'theme', 'themeData'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $request->validate([
                'file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'product_id' => 'nullable'
            ]);
            // dd($data);
            
            foreach ($request->file('file') as $file) {
                $path = $file->store($this->pathUploadImage, 'public');
                
                ProductGallery::create([
                    'product_id' => null,
                    'file' => $path,
                    'active' => 1,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Arquivos enviados com sucesso!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao enviar arquivos: ' . $e->getMessage());
        }
    }


    public function destroy(ProductGallery $productGallery)
    {
        Storage::delete(isset($productGallery->file) ? $productGallery->file : '');
        $productGallery->delete();

        Session::flash('success','Arquivo(s) deletado com sucesso!');
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {
        if($deleted = ProductGallery::whereIn('id', $request->deleteAll)->delete()){
            return Response::json
            (
                [
                    'status' => 'success',
                    'message' => $deleted.' itens deletados com sucessso!'
                ]
            );
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $productGallery = ProductGallery::find($id);
    
            if ($productGallery) {
                $productGallery->sorting = $sorting;
                $productGallery->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($productGallery) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($productGallery)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'path_image' => $productGallery->path_image,
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
