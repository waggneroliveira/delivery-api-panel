<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\JsonResponse;

class SlideController extends Controller
{
    public function index(): JsonResponse
    {
        $slide = Slide::active()
            ->sorting()
            ->first(['path_image', 'path_image_mobile']);

        return response()->json([
            'data' => $slide?->only(['path_image', 'path_image_mobile']),
        ]);
    }
}
