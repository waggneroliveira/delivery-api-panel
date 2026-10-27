<?php

namespace App\Modules\Client\Business;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class ProductPageService
{
    public function getProductListData(Request $request, ThemeManager $themeManager): array
    {
        $category = $request->get('category');
        $brand = $request->get('brand');
        $search = $request->get('search');

        $category = $category !== 'all' ? $category : null;
        $brand = $brand !== 'all' ? $brand : null;

        $products = Product::with(['category', 'brand'])
            // Categoria é obrigatória e precisa estar ativa
            ->whereHas('category', fn ($q) => $q->active())

            // Marca é opcional. Só filtra se uma marca foi selecionada.
            ->when($brand, fn ($query) =>
                $query->whereHas('brand', fn ($q) =>
                    $q->where('slug', $brand)->active()
                )
            )

            // Filtro por categoria
            ->when($category, fn ($query) =>
                $query->whereHas('category', fn ($q) =>
                    $q->where('slug', $category)->active()
                )
            )

            // Busca
            ->when($search, fn ($query) =>
                $query->where(fn ($q) =>
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                )
            )

            ->active()
            ->sorting()
            ->get();


        // Categorias ativas que possuem pelo menos um produto ativo
        $productCategories = ProductCategory::whereHas('products', function ($query) {
                $query->active();
            })
            ->active()
            ->sorting()
            ->get();


        // Marcas ativas que possuem pelo menos um produto ativo
        // e cuja categoria esteja ativa
        $brands = Brand::whereHas('products', function ($query) {
                $query->active()
                    ->whereHas('category', fn ($q) => $q->active());
            })
            ->active()
            ->sorting()
            ->get();


        // Título
        $title = 'Todos os Produtos';

        if ($category && $brand) {

            $categoryModel = ProductCategory::active()
                ->where('slug', $category)
                ->first();

            $brandModel = Brand::active()
                ->where('slug', $brand)
                ->first();

            if (!$categoryModel || !$brandModel) {
                $products = collect();
                $title = 'Nenhum produto encontrado';
            } else {
                $title = "{$categoryModel->title} - {$brandModel->title}";
            }

        } elseif ($category) {

            $categoryModel = ProductCategory::active()
                ->where('slug', $category)
                ->first();

            if ($categoryModel) {
                $title = $categoryModel->title;
            } else {
                $products = collect();
                $title = 'Nenhum produto encontrado';
            }

        } elseif ($brand) {

            $brandModel = Brand::active()
                ->where('slug', $brand)
                ->first();

            if ($brandModel) {
                $title = $brandModel->title;
            } else {
                $products = collect();
                $title = 'Nenhum produto encontrado';
            }
        }
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        
        return compact('products', 'productCategories', 'brands', 'title', 'tenantTheme', 'theme', 'themeData');
    }

    public function getProductViewData($category = null, $slug = null, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        if (!$category || !$slug) {
            return ['view' => view($theme->error('404'))];
        }
        
        $product = Product::with(['category', 'brand', 'galleries' => fn ($q) => $q->active()->sorting()])
        ->whereHas('category', fn ($q) => $q->active())
        ->where('slug', $slug)
        ->active()
        ->first();
        
        if ($product === null) {
            return ['view' => view($theme->error('404'))];
        }

        return [
            'product' => $product,
            'theme' => $theme,
            'themeData' => $themeData,
            'tenantTheme' => $tenantTheme,
        ];
    }
}
