<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Tenant;
use App\Modules\Client\Business\ProductPageService;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class ProductPageController
{
    public function __construct(protected ProductPageService $service)
    {
    }

    public function productAll(Request $request, ThemeManager $theme)
    {
        $data = $this->service->getProductListData($request, $theme);

        if ($request->ajax()) {
            return response()->json([
                'html' => view($theme->includes('products'), $data)->render(),
                'title' => $data['title'],
            ]);
        }

        return view($theme->view('products'), $data);
    }

    public function productView($category = null, $slug = null, ThemeManager $theme)
    {
        $tenantTheme = Tenant::current();
        $data = $this->service->getProductViewData($category, $slug, $theme);

        // Se o service já definiu uma view de erro/fallback
        if (isset($data['view'])) {
            return $data['view']->with('theme', $theme)->with('tenantTheme', $tenantTheme);
        }

        // Página interna do produto
        $viewName = $theme->view('product');

        if (View::exists($viewName)) {
            return view($viewName, $data)->with('theme', $theme)->with('tenantTheme', $tenantTheme);
        }

        // Template não possui página interna de produto
        return view($theme->error('404'))->with('theme', $theme)->with('tenantTheme', $tenantTheme);
    }
}
