<?php

use App\Http\Controllers\Admin\AdditionalProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\StorageConditionsTemplateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(env('APP_DOMAIN'))->group(static function () {
    Route::middleware(['auth', 'verified'])->group(static function () {
        Route::get('/', static function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('products/{product}/image-with-description', [ProductController::class, 'getImageWithDescription'])
        ->name('get-image-with-description');
        Route::get('products/ingredients', [ProductController::class, 'getIngredients'])->name('products.ingredients');
        Route::resource('products', ProductController::class);

        Route::patch('categories/update-sort', [CategoryController::class, 'updateSort'])
            ->name('categories.update-sort');
        Route::resource('categories', CategoryController::class);

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');

        Route::resource('promo-codes', PromoCodeController::class);

        Route::resource('additional-products', AdditionalProductController::class);

        Route::resource('storage-conditions-templates', StorageConditionsTemplateController::class);
    });

    require __DIR__ . '/auth.php';
});
