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

        return view('admin.blades.product.index', $data);
    }

    /**
     * Lista os produtos cadastrados em formato JSON.
     */
    public function jsonIndex(
        Request $request,
        ThemeManager $theme
    ): JsonResponse {
        $data = $this->service->getIndexData($request, $theme);

        if (isset($data['forbidden'])) {
            return response()->json([
                'message' => 'Você não tem permissão para visualizar produtos.',
            ], 403);
        }

        $products = $data['products'];
        $products->getCollection()->load([
            'category',
            'brand',
            'galleries',
            'options',
            'comboItems.options',
            'comboAddons',
        ]);

        return response()->json($products);
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

        return view('admin.blades.product.create', $data);
    }

    /**
     * Documenta em JSON a estrutura esperada pelo cadastro de produtos.
     */
    public function structure(): JsonResponse
    {
        return response()->json([
            'message' => 'Estrutura usada pelo formulário de cadastro de produtos.',
            'submit' => [
                'method' => 'POST',
                'url' => route('admin.dashboard.product.store'),
                'content_type' => 'multipart/form-data',
            ],
            'prices' => [
                'display_format' => '1.234,56',
                'submitted_format' => '1234.56',
                'note' => 'O formulário também aceita valores no formato brasileiro.',
            ],
            'product_fields' => [
                'product_type' => ['food', 'combo'],
                'title' => 'Nome do produto',
                'product_category_id' => 'ID da categoria',
                'brand_id' => 'ID da marca (opcional)',
                'price' => 'Preço de venda',
                'old_price' => 'Preço anterior (opcional)',
                'description' => 'Descrição curta (opcional)',
                'text' => 'Descrição completa (opcional)',
                'cuisine_type' => 'Tipo de cozinha (opcional)',
                'tags' => 'Lista de tags enviada pelo formulário como texto JSON',
                'stock' => [
                    'quantity' => 'Quantidade disponível',
                    'control' => '1 para controlar estoque, 0 para não controlar',
                ],
                'featured' => 'Se o produto será destacado',
                'active' => 'Se o produto ficará disponível para venda',
            ],
            'food_product_example' => [
                'product_type' => 'food',
                'title' => 'X-Burger Especial',
                'product_category_id' => 1,
                'brand_id' => null,
                'price' => '29.90',
                'old_price' => '34.90',
                'description' => 'Hambúrguer artesanal com queijo.',
                'cuisine_type' => 'Hambúrguer',
                'tags' => '["artesanal","mais vendido"]',
                'stock' => [
                    'quantity' => 20,
                    'control' => 1,
                ],
                'featured' => 0,
                'active' => 1,
                'options' => [
                    [
                        'title' => 'Tamanho',
                        'type' => 'single',
                        'max_selections' => 1,
                        'required' => 1,
                        'choices' => [
                            [
                                'id' => 'choice-grande',
                                'name' => 'Grande',
                                'price' => '5.00',
                                'description' => 'Serve duas pessoas.',
                                'maxQuantity' => 1,
                                'category' => 'Tamanho',
                                'default' => 0,
                                'isRecommended' => 1,
                            ],
                        ],
                    ],
                ],
                'combo_items' => [],
                'combo_addons' => [],
            ],
            'combo_product_example' => [
                'product_type' => 'combo',
                'title' => 'Combo Burger',
                'product_category_id' => 1,
                'price' => '39.90',
                'options' => [],
                'combo_items' => [
                    [
                        'name' => 'X-Burger',
                        'quantity' => 1,
                        'required' => 1,
                    ],
                    [
                        'name' => 'Refrigerante',
                        'quantity' => 1,
                        'required' => 1,
                        'options' => [
                            [
                                'title' => 'Sabor',
                                'type' => 'single',
                                'max_selections' => 1,
                                'required' => 1,
                                'choices' => [
                                    [
                                        'id' => 'sabor-cola',
                                        'name' => 'Cola',
                                        'price' => '0.00',
                                    ],
                                    [
                                        'id' => 'sabor-guarana',
                                        'name' => 'Guaraná',
                                        'price' => '0.00',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'combo_addons' => [
                    [
                        'name' => 'Batata frita grande',
                        'price' => '8.00',
                        'max_quantity' => 1,
                    ],
                ],
            ],
            'notes' => [
                'As escolhas são preenchidas como campos do formulário, não como JSON digitado manualmente.',
                'Cada escolha pode ter id, name, price, description, maxQuantity, category, default e isRecommended.',
                'As opções de cada item de combo ficam em combo_items[n].options[m], e suas escolhas em combo_items[n].options[m].choices.',
                'Os preços são salvos em formato decimal e normalizados no servidor.',
                'Imagens e arquivos são enviados como arquivos multipart.',
            ],
        ]);
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

        return view('admin.blades.product.edit', $data);
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
