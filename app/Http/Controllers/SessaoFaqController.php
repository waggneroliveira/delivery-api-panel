<?php

namespace App\Http\Controllers;

use App\Models\SessaoFaq;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class SessaoFaqController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/sessao-faq/";
    }
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'faq_session' → é o módulo definido no template_modules.php.
        // 'sesssao faq.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('faq_session', 'sesssao faq.visualizar', $settingTheme);

        if ($check !== true) {
            return $check; // retorna view 403
        }

        $sessaoFaq = SessaoFaq::first();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.sessaoFaq.index', compact('sessaoFaq', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $request->except('path_file');
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_file' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');

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
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_file'] = $pathUpload . $filename;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();
                SessaoFaq::create($data);
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

        return redirect()->back();
    }

    public function update(Request $request, SessaoFaq $sessaoFaq)
    {
        $data = $request->except('path_file');
        $pathUpload = $this->getPathUpload();
        $manager = new ImageManager(new ImagickDriver());

        $request->validate([
            'path_file' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');

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
                    ->toAvif(quality: 95)
                    ->toString();

                Storage::put(
                    $pathUpload . $filename,
                    $image
                );
            }

            if (!empty($sessaoFaq->path_file)) {
                Storage::delete(
                    $sessaoFaq->path_file
                );
            }

            $data['path_file'] = $pathUpload . $filename;
        }

        if ($request->has('delete_path_file')) {
            if (
                !empty($sessaoFaq->path_file) &&
                Storage::exists($sessaoFaq->path_file)
            ) {
                Storage::delete(
                    $sessaoFaq->path_file
                );
            }

            $data['path_file'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {
            DB::beginTransaction();
                $sessaoFaq->fill($data)->save();
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

        return redirect()->back();
    }

    public function destroy(SessaoFaq $sessaoFaq)
    {
        Storage::delete(isset($sessaoFaq->path_file)??$sessaoFaq->path_file);
        $sessaoFaq->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
