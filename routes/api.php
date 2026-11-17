<?php

use App\Http\Controllers\Api\AnnoumcementsController;
use App\Http\Controllers\Api\AppearanceController;
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CustomerAddress;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceLocationController;
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

        // Endereços
        Route::get('/addresses', [CustomerAddress::class, 'index'])
            ->name('api.client.addresses.index');

        Route::post('/addresses', [CustomerAddress::class, 'store'])
            ->name('api.client.addresses.store');

        Route::get('/addresses/{address}', [CustomerAddress::class, 'show'])
            ->name('api.client.addresses.show');

        Route::put('/addresses/{address}', [CustomerAddress::class, 'update'])
            ->name('api.client.addresses.update');

        Route::patch('/addresses/{address}', [CustomerAddress::class, 'update']);

        Route::delete('/addresses/{address}', [CustomerAddress::class, 'destroy'])
            ->name('api.client.addresses.destroy');

        // Pedidos
        Route::prefix('orders')
        ->name('api.client.orders.')
        ->controller(OrderController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::post('/', 'store')
                ->name('store');

            Route::get('/{id}', 'show')
                ->name('show');

        });

    });
});

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/tenant', [TenantController::class, 'show'])
    ->name('api.tenant.show');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/appearance', [AppearanceController::class, 'show'])
    ->name('api.appearance.show');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/slides', [SlideController::class, 'index'])
    ->name('api.slides.index');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/category', [ProductCategoryController::class, 'index'])
    ->name('api.product-category.index');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/products', [ProductController::class, 'index'])
    ->name('api.products.index');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/service-locations', [ServiceLocationController::class, 'index'])
    ->name('api.service-locations.index');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/contacts', [ContactController::class, 'index'])
    ->name('api.contacts.index');

Route::middleware([EnsureApiJson::class, EnsureApiTenant::class])
    ->get('/announcements', [AnnoumcementsController::class, 'index'])
    ->name('api.announcements.index');
