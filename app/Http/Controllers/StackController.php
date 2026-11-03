<?php

namespace App\Http\Controllers;

use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\StackSessionTitle;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Illuminate\Support\Facades\Log;

class StackController extends Controller
{
    protected $pathUpload = 'admin/uploads/image/thumb/';
    public function index()
    {
        $stacks = Stack::sorting()->get();
        $stackSessionTitle = StackSessionTitle::first();
        return view('admin.blades.stack.index', compact('stacks', 'stackSessionTitle'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['path_image']);
        $helper = new HelperArchive();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_image' => ['nullable', 'file', 'image', 'max:2048', 'mimes:jpg,svg,jpeg,png,gif,webp'],
        ]);

        $path_image = $helper->renameArchiveUpload($request, 'path_image', $this->pathUpload, true);
        if ($path_image) {
            $data['path_image'] = $this->pathUpload . $path_image;
            $file = $request->file('path_image');
            $mime = $file->getMimeType();
            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $path_image);
            } else {
                // Compressão webp com qualidade 75 para reduzir o peso
                $image = $manager->read($file)->toWebp(quality: 75)->toString();
                Storage::put($this->pathUpload . $path_image, $image);
            }
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();
                Stack::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Stack $stack)
    {
        $data = $request->all();
        $helper = new HelperArchive();
        $manager = new ImageManager(new ImagickDriver());

        $path_image = $helper->renameArchiveUpload($request, 'path_image', $this->pathUpload, true);
        if ($path_image) {
            $data['path_image'] = $this->pathUpload . $path_image;
            $file = $request->file('path_image');
            $mime = $file->getMimeType();
            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $path_image);
            } else {
                // Compressão webp com qualidade 75 para reduzir o peso
                $image = $manager->read($file)->toWebp(quality: 75)->toString();
                Storage::put($this->pathUpload . $path_image, $image);
            }
            Storage::delete(isset($stack->path_image)?$stack->path_image:'');
        }
        if(isset($request->delete_path_image) && !$path_image){
            $inputFile = $request->delete_path_image;
            Storage::delete($stack->$inputFile);
            $data['path_image'] = null;
        }

                try {
            DB::beginTransaction();
                $data['active'] = $request->active ? 1 : 0;
                
                $stack->fill($data)->save();

                //stack desktop 
                if ($path_image) {
                    Storage::delete($this->pathUpload . $path_image);
                }
                if ($path_image) {
                    $request->file('path_image')->storeAs($this->pathUpload, $path_image);
                }

            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(Stack $stack)
    {
        Storage::delete(isset($stack->path_image)??$stack->path_image);
        $stack->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $stackId) {
            $stack = Stack::find($stackId);
    
            if ($stack) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($stack)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $stackId,
                            'path_image' => $stack->path_image,
                            'title' => $stack->title,
                            'sorting' => $stack->sorting,
                            'active' => $stack->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $stackId não encontrado.");
            }
        }
    
        $deleted = Stack::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $stack = Stack::find($id);
    
            if ($stack) {
                $stack->sorting = $sorting;
                $stack->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($stack) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($stack)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'path_image' => $stack->path_image,
                            'title' => $stack->title,
                            'sorting' => $stack->sorting,
                            'active' => $stack->active,
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
