<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServerController;
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
        });
    });
});
