<?php

namespace App\Modules\Product\Presentation\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Modules\Product\Business\ProductService;
use App\Services\ThemeManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProductController
{
    public function __construct(protected ProductService $service)
    {
    }

    public function index(Request $request, ThemeManager $theme): View|RedirectResponse
    {
        $data = $this->service->getIndexData($request, $theme);
        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }
        
        return view('admin.blades.product.index', $data);
    }

    public function create(ThemeManager $theme): View|RedirectResponse
    {
        $data = $this->service->getCreateData($theme);
        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.blades.product.create', $data);
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $this->service->store($request);
        session()->flash('success', __('dashboard.response_item_create'));

        return redirect()->route('admin.dashboard.product.index');
    }

    public function edit(Product $product, ThemeManager $theme): View|RedirectResponse
    {
        $data = $this->service->getEditData($product, $theme);
        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.blades.product.edit', $data);
    }

    public function uploadImageCkeditor(Request $request)
    {
        return response()->json($this->service->uploadImageCkeditor($request));
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $this->service->update($request, $product);
        session()->flash('success', __('dashboard.response_item_update'));

        return redirect()->route('admin.dashboard.product.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->service->delete($product);
        Session::flash('success', __('dashboard.response_item_delete'));

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
