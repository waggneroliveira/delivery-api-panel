<?php

namespace App\Modules\Product\Presentation\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Modules\Product\Business\ProductService;
use App\Services\ThemeManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController
{
    public function __construct(
        protected ProductService $service
    ) {
    }

    /**
     * Lista os produtos.
     */
    public function index(
        Request $request,
        ThemeManager $theme
    ): View|RedirectResponse {
        $data = $this->service->getIndexData($request, $theme);

        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.dashboard.product.index', $data);
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function create(
        ThemeManager $theme
    ): View|RedirectResponse {
        $data = $this->service->getCreateData($theme);

        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.dashboard.product.create', $data);
    }

    /**
     * Armazena um novo produto.
     */
    public function store(
        ProductStoreRequest $request
    ): RedirectResponse {
        $this->service->store($request);

        session()->flash(
            'success',
            __('dashboard.response_item_create')
        );

        return redirect()->route('admin.dashboard.product.index');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(
        Product $product,
        ThemeManager $theme
    ): View|RedirectResponse {
        $data = $this->service->getEditData($product, $theme);

        if (isset($data['forbidden'])) {
            return $data['forbidden'];
        }

        return view('admin.dashboard.product.edit', $data);
    }

    /**
     * Upload de imagens pelo CKEditor.
     */
    public function uploadImageCkeditor(
        Request $request
    ): JsonResponse {
        return response()->json(
            $this->service->uploadImageCkeditor($request)
        );
    }

    /**
     * Atualiza um produto existente.
     */
    public function update(
        ProductUpdateRequest $request,
        Product $product
    ): RedirectResponse {
        $this->service->update($request, $product);

        session()->flash(
            'success',
            __('dashboard.response_item_update')
        );

        return redirect()->route('admin.dashboard.product.index');
    }

    /**
     * Exclui um produto.
     */
    public function destroy(
        Product $product
    ): RedirectResponse {
        $this->service->delete($product);

        session()->flash(
            'success',
            __('dashboard.response_item_delete')
        );

        return redirect()->back();
    }

    /**
     * Exclui vários produtos selecionados.
     */
    public function destroySelected(
        Request $request
    ): JsonResponse {
        $result = $this->service->destroySelected($request);

        return response()->json([
            'status' => 'success',
            'message' => ($result['deleted'] ?? 0) . ' ' .
                __('dashboard.response_item_delete'),
        ]);
    }

    /**
     * Atualiza a ordenação dos produtos.
     */
    public function sorting(
        Request $request
    ): JsonResponse {
        $this->service->sorting($request);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
