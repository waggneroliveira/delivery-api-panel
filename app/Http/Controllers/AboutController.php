<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Repositories\SettingThemeRepository;
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
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/about/";
    }

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'slides' → é o módulo definido no template_modules.php.
        // 'slide.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('about', 'sobre nos.visualizar', $settingTheme);
        if ($check !== true) {
            return $check; // retorna view 403
        }

        $abouts = About::get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $aboutLimit = $themeManager->getLimit('about', 0);

        return view('admin.blades.about.index', compact('abouts', 'theme', 'themeData', 'aboutLimit'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048'],
        ]);

        $data = $request->except([
            'path_image'
        ]);

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        // Imagem do About
        if ($request->hasFile('path_image')) {

            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {

                $filename = Str::uuid() . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );

            } else {

                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            About::create($data);

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_create')
            );
        }

        return redirect()
            ->route('admin.dashboard.about.index');


    }


    public function create(ThemeManager $themeManager){
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') &&  
          !Auth::user()->hasPermissionTo('sobre nos.visualizar') &&
          !Auth::user()->hasPermissionTo('sobre nos.criar')){
            return view('admin.error.403', compact('settingTheme'));
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.about.create', compact('theme', 'themeData'));
    }

    public function edit(About $about, ThemeManager $themeManager){
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') && 
          !Auth::user()->hasPermissionTo('sobre nos.visualizar') && 
          !Auth::user()->hasPermissionTo('sobre nos.editar')){
            return view('admin.error.403', compact('settingTheme'));
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.about.edit', compact('about', 'theme', 'themeData'));
    }

    public function uploadImageCkeditorAbout(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $mime = $file->getMimeType();

            // Nome do arquivo sem extensão + .webp
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';

            // Caminho de armazenamento
            $pathUpload = 'uploads/blog_images/';

            $manager = ImageManager::gd(); // ou ->imagick() se preferir

            if ($mime === 'image/svg+xml') {
                // Apenas copiar o SVG sem conversão
                Storage::disk('public')->putFileAs($pathUpload, $file, $filename);
            } else {
                // Converter em WEBP
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 90)
                    ->toString();

                Storage::disk('public')->put($pathUpload . $filename, $image);
            }

            $url = asset('storage/' . $pathUpload . $filename);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Upload falhou.']
        ]);
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'path_image' => ['nullable','file','image','max:2048']
        ]);

        $data = $request->except([
            'path_image'
        ]);

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        // About image
        if ($request->hasFile('path_image')) {

            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {

                $filename = Str::uuid() . '.svg';

                Storage::putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );

            } else {

                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            // Remove a imagem antiga somente após salvar a nova
            if (!empty($about->path_image)) {
                Storage::delete($about->path_image);
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        // Remove imagem somente quando não houver novo upload
        if (
            $request->filled('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {

            if (!empty($about->path_image)) {
                Storage::delete($about->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            $about->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->route('admin.dashboard.about.index');

    }


    public function destroy(About $about)
    {
        Storage::delete(isset($about->path_image)??$about->path_image);
        $about->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $aboutId) {
            $about = About::find($aboutId);
    
            if ($about) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($about)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $aboutId,
                            'path_image' => $about->path_image,
                            'title' => $about->title,
                            'text' => $about->text,
                            'sorting' => $about->sorting,
                            'active' => $about->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $aboutId não encontrado.");
            }
        }
    
        $deleted = About::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $about = About::find($id);
    
            if ($about) {
                $about->sorting = $sorting;
                $about->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($about) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($about)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'path_image' => $about->path_image,
                            'title' => $about->title,
                            'text' => $about->text,
                            'sorting' => $about->sorting,
                            'active' => $about->active,
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
