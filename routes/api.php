<?php

use Illuminate\Http\Request;
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

Route::prefix('container')->group(function () {
    Route::get('/', 'ContainerController@index');
    Route::post('/put', 'ContainerController@put');
});

Route::prefix('kitara')->group(function () {
    Route::get('/product', 'KitaraController@product');
    Route::post('/product/{id}/pessimisticOrder', 'KitaraController@pessimisticOrder');
    Route::post('/product/{id}/optimisticOrder', 'KitaraController@optimisticOrder');
    Route::get('/order', 'KitaraController@order');
});
