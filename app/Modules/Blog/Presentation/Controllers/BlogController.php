<?php

namespace App\Modules\Blog\Presentation\Controllers;

use App\Http\Requests\BlogRequestStore;
use App\Http\Requests\BlogRequestUpdate;
use App\Models\Blog;
use App\Modules\Blog\Business\BlogService;
use App\Services\ThemeManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController
{
    public function __construct(protected BlogService $service)
    {
    }

    public function index(Request $request, ThemeManager $theme): View|RedirectResponse
    {
        $data = $this->service->getIndexData($request, $theme);
        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }
        return view('admin.blades.blog.index', $data);
    }

    public function create(ThemeManager $theme): View|RedirectResponse
    {
        $data = $this->service->getCreateData($theme);
        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.blades.blog.create', $data);
    }


    public function edit(Blog $blog, ThemeManager $theme): View|RedirectResponse
    {
        $data = $this->service->getEditData($blog, $theme);
        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.blades.blog.edit', $data);
    }

    public function store(BlogRequestStore $request): RedirectResponse
    {
        $this->service->store($request);
        session()->flash('success', __('dashboard.response_item_create'));

        return redirect()->route('admin.dashboard.blog.index');
    }

    public function uploadImageCkeditor(Request $request)
    {
        return response()->json($this->service->uploadImageCkeditor($request));
    }

    public function update(BlogRequestUpdate $request, Blog $blog): RedirectResponse
    {
        $this->service->update($request, $blog);
        session()->flash('success', __('dashboard.response_item_update'));

        return redirect()->route('admin.dashboard.blog.index');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->service->delete($blog);
        session()->flash('success', __('dashboard.response_item_delete'));

        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {
        $result = $this->service->destroySelected($request);

        return response()->json([
            'status' => 'success',
            'message' => ($result['deleted'] ?? 0) . ' ' . __('dashboard.response_item_delete'),
        ]);
    }

    public function sorting(Request $request)
    {
        $this->service->sorting($request);

        return response()->json(['status' => 'success']);
    }
}
