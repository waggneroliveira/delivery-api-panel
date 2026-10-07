<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use Log;
use RealRashid\SweetAlert\Facades\Alert;

class TopicController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/topics/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // Verifica permissão para visualizar slides
        $check = checkPermission('topics', 'topico.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $topics = Topic::select(
            'id',
            'tenant_id',
            'title',
            'active',
            'link',
            'description',
            'btn_title',
            'color',
            'sorting',
            'path_image',
        )->sorting()->get();
        
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        
        return view('admin.blades.topic.index', compact('topics', 'theme', 'themeData'));
    }

    public function store(Request $request, ThemeManager $themeManager)
    {
        $request->validate([
        'path_image' => ['nullable', 'file', 'image', 'max:2048']
        ]);

        $data = $request->except([
            'path_image',
            'path_image_mobile'
        ]);

        $data['active'] = $request->active ? 1 : 0;

        $limit = $themeManager->getLimit('topics', 0);

        $currentCount = Topic::count();

        if ($limit !== null && $currentCount >= $limit) {
            return back()->with(
                'error',
                'O limite de tópicos deste cliente foi atingido.'
            );
        }

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        if ($request->hasFile('path_image')) {

            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {

                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );

            } else {

                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.avif';

                $image = $manager
                    ->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        try {

            DB::beginTransaction();

            Topic::create($data);

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );

            return redirect()->back();

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error(
                'error',
                __('dashboard.response_item_error_create')
            );

            return redirect()->back();
        }

    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
        'path_image' => ['nullable', 'file', 'image', 'max:2048']
        ]);

        $data = $request->except([
            'path_image',
            'path_image_mobile'
        ]);

        $data['active'] = $request->active ? 1 : 0;

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        if ($request->hasFile('path_image')) {

            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {

                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );

            } else {

                $filename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ) . '.avif';

                $image = $manager
                    ->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            if (!empty($topic->path_image)) {
                Storage::delete($topic->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        try {

            DB::beginTransaction();

            $topic->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

            return redirect()->back();

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error(
                'error',
                __('dashboard.response_item_error_update')
            );

            return redirect()->back();
        }        
    }


    public function destroy(Topic $topic)
    {
        Storage::delete(isset($topic->path_image)??$topic->path_image);
        $topic->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $topicId) {
            $topic = Topic::find($topicId);
    
            if ($topic) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($topic)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $topicId,
                            'title' => $topic->title,
                            'path_image' => $topic->path_image,
                            'sorting' => $topic->sorting,
                            'active' => $topic->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $topicId não encontrado.");
            }
        }
    
        $deleted = Topic::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $topic = Topic::find($id);
    
            if ($topic) {
                $topic->sorting = $sorting;
                $topic->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($topic) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($topic)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $topic->title,
                            'path_image' => $topic->path_image,
                            'sorting' => $topic->sorting,
                            'active' => $topic->active,
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
