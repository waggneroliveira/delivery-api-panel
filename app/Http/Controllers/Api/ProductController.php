<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::active()
            ->with([
                'category',
                'brand',
                'galleries',
                'options',
                'comboItems.options',
                'comboAddons',
            ])
            ->whereHas('category')
            ->sorting()
            ->get();

        return response()->json([
            'data' => $products,
        ]);
    }
}
