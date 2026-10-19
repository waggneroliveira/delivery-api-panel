<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Project;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class ProjectController extends Controller
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/projects/";
    }

    public function store(Request $request)
    {
        $request->validate([
        'path_image' => [ 'nullable','file','image','max:2048'],
        ]);

        $data = $request->except([
            'path_image'
        ]);

        $pathUpload = $this->getPathUpload();

        $helper = new HelperArchive();

        $manager = new ImageManager(new ImagickDriver());

        $filename = null;
        
        if ($request->hasFile('path_image')) {

            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            $originalFilename = $helper->renameArchiveUpload(
                $request,
                'path_image',
                $pathUpload,
                true
            );

            if ($originalFilename) {

                if ($mime === 'image/svg+xml') {

                    $filename = pathinfo(
                        $originalFilename,
                        PATHINFO_FILENAME
                    ) . '.svg';

                    Storage::putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );

                } else {

                    $filename = pathinfo(
                        $originalFilename,
                        PATHINFO_FILENAME
                    ) . '.avif';

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
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            Project::create($data);

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );

            return redirect()->back();

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_create')
            );

            return redirect()->back();
        }
    }


    public function update(Request $request, Project $project)
    {
        $request->validate([
        'path_image' => ['nullable','file','image', 'max:2048'],
        ]);

        $data = $request->except([
            'path_image'
        ]);

        $pathUpload = $this->getPathUpload();

        $helper = new HelperArchive();

        $manager = new ImageManager(new ImagickDriver());

        $filename = null;

        if ($request->hasFile('path_image')) {

            $file = $request->file('path_image');

            $mime = $file->getMimeType();

            $originalFilename = $helper->renameArchiveUpload(
                $request,
                'path_image',
                $pathUpload,
                true
            );

            if ($originalFilename) {

                if ($mime === 'image/svg+xml') {

                    $filename = pathinfo(
                        $originalFilename,
                        PATHINFO_FILENAME
                    ) . '.svg';

                    Storage::putFileAs(
                        $pathUpload,
                        $file,
                        $filename
                    );

                } else {

                    $filename = pathinfo(
                        $originalFilename,
                        PATHINFO_FILENAME
                    ) . '.avif';

                    $image = $manager
                        ->read($file)
                        ->toAvif(quality: 90)
                        ->toString();

                    Storage::put(
                        $pathUpload . $filename,
                        $image
                    );
                }

                if (!empty($project->path_image)) {
                    Storage::delete($project->path_image);
                }

                $data['path_image'] = $pathUpload . $filename;
            }
        }

        if (
            $request->filled('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {

            if (!empty($project->path_image)) {
                Storage::delete($project->path_image);
            }

            $data['path_image'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        try {

            DB::beginTransaction();

            $project->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

            return redirect()->back();

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );

            return redirect()->back();
        }


    }

    public function destroy(Project $project)
    {
        Storage::delete(isset($project->path_image)??$project->path_image);
        $project->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
