<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:admin')->prefix('admin')->group(function (){

    Route::get('categories/trash' , [CategoryController::class , 'trash']);
    Route::put('categories/{category}/restore' , [CategoryController::class , 'restore']);
    Route::delete('categories/{category}/force-delete' , [CategoryController::class , 'forceDelete']);

    Route::apiResource('categories' , CategoryController::class);
    Route::apiResource('tags' , TagController::class);
    Route::apiResource('products' , ProductController::class);
    Route::apiResource('cart' , \App\Http\Controllers\Front\CartController::class);
});

Route::middleware('auth:user')->prefix('admin')->group(function (){
    Route::apiResource('products' , ProductController::class)->only(['show' , 'index']);
    Route::patch('profile' , [ProfileController::class , 'update']);


    Route::apiResource('cart' , \App\Http\Controllers\Front\CartController::class)->only('show');
    Route::get('checkout' , [\App\Http\Controllers\Front\CheckoutController::class , 'show']);
    Route::post('checkout' , [\App\Http\Controllers\Front\CheckoutController::class , 'store']);

});


