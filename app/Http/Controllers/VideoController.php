<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class VideoController extends Controller
{

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('videos', 'video.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $videos = Video::get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $videoLimit = $themeManager->getLimit('videos', 0);

        return view('admin.blades.video.index', compact('videoLimit', 'videos', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        try {
            DB::beginTransaction();
                Video::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
        } catch (\Exception $e) {
            DB::rollback();            
            Alert::error('error', __('dashboard.response_item_error_create'));
        }
        return redirect()->back();
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        try {
            DB::beginTransaction();
                $video->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));

        }
        return redirect()->back();
    }

    public function destroy(Video $video)
    {
        $video->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $videoId) {
            $video = Video::find($videoId);
    
            if ($video) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($video)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $videoId,
                            'link' => $video->link,
                            'sorting' => $video->sorting,
                            'active' => $video->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $videoId não encontrado.");
            }
        }
    
        $deleted = Video::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $video = Video::find($id);
    
            if ($video) {
                $video->sorting = $sorting;
                $video->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($video) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($video)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'link' => $video->link,
                            'sorting' => $video->sorting,
                            'active' => $video->active,
                            'event' => 'order_updated',
                        ]
                    ])
                    ->log('order_updated');
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }
        }
    
        return Response::json(['status' => 'success']);
    }
}
