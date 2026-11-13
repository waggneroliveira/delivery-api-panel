<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function index(): JsonResponse
    {
        $productCategories = ProductCategory::active()
            ->sorting()
            ->get([
                'title',
                'slug',
                'active',
                'highlight',
                'path_image',
                'sorting',
            ]);

        return response()->json([
            'data' => $productCategories,
        ]);
    }

}
