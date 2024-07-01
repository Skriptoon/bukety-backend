<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$domain = env('APP_ENV') === 'testing' ? env('APP_DOMAIN') : env('API_DOMAIN');
Route::domain($domain)->group(static function (): void {
    Route::middleware('api')->group(function (): void {
        Route::middleware('guest')->group(function (): void {
            Route::get('categories', [CategoryController::class, 'index']);
            Route::get('categories/{category:slug}', [CategoryController::class, 'show']);

            Route::prefix('products')->group(static function (): void {
                Route::get('/', [ProductController::class, 'index']);
                Route::get('{product:slug}', [ProductController::class, 'show']);
                Route::get('{product:slug}/recommended', [ProductController::class, 'recommended']);
            });

            Route::post('order', [OrderController::class, 'store']);
        });
    });
});
