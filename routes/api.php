<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-all-category-info', [APIController::class, 'getAllCategoryInfo']);
Route::get('/get-trending-product', [APIController::class, 'getTrendingProduct']);
Route::get('/get-category-product/{id}', [APIController::class, 'getCategoryProduct']);
Route::get('/get-product-info-by-id/{id}', [APIController::class, 'getProductInfo']);
