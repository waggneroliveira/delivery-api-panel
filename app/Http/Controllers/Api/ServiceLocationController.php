<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceLocation;
use Illuminate\Http\JsonResponse;

class ServiceLocationController extends Controller
{
    public function index(): JsonResponse
    {
        $serviceLocations = ServiceLocation::active()
            ->orderBy('id')
            ->get([
                'id',
                'title',
                'description',
                'path_image',
                'neighborhoods',
            ]);

        return response()->json([
            'data' => $serviceLocations,
        ]);
    }
}
