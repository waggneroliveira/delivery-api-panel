<?php

use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Middleware\EnsureApiJson;
use App\Http\Middleware\EnsureApiTenant;
use App\Http\Middleware\EnsureClientApiAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return ['pong' => true];
});

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->prefix('client')
    ->group(function () {
    Route::post('/login', [AuthClientController::class, 'login'])
        ->name('api.client.login');

    Route::middleware(EnsureClientApiAuthenticated::class)->group(function () {
        Route::get('/me', [ClientController::class, 'show'])
            ->name('api.client.show');
        Route::put('/me', [ClientController::class, 'update'])
            ->name('api.client.update');
        Route::patch('/me', [ClientController::class, 'update']);
        Route::delete('/me', [ClientController::class, 'destroy'])
            ->name('api.client.destroy');
        Route::post('/logout', [AuthClientController::class, 'logout'])
            ->name('api.client.logout');
    });
});

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/tenant', [TenantController::class, 'show'])
    ->name('api.tenant.show');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/slides', [SlideController::class, 'index'])
    ->name('api.slides.index');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/categoria', [ProductCategoryController::class, 'index'])
    ->name('api.product-category.index');
