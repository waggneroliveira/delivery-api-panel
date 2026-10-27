<?php

namespace App\Http\Controllers;

use App\Models\ProductGallery;
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

class ProductGalleryController extends Controller
{

    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);
        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';
        return "admin/uploads/images/templates/{$template}/{$variation}/product-gallery/";
    }

    public function store(Request $request)
    {
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'file.*' => ['required', 'file', 'image', 'max:2048'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->file('file', []) as $file) {
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

                ProductGallery::create([
                    'product_id' => $request->product_id,
                    'file' => $pathUpload . $filename,
                    'active' => 1,
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Arquivos enviados com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Erro ao enviar arquivos: ' . $e->getMessage());
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
