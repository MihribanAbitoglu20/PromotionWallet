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
Route::get('backoffice/promotion-codes/{id?}',['App\Http\Controllers\WalletController','listPromotion']);
Route::post('backoffice/promotion-codes',['App\Http\Controllers\WalletController','savePromotion']);
Route::post('assign-promotion',['App\Http\Controllers\WalletController','assignPromotion']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
