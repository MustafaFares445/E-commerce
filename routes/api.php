<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
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


Route::get('categories/trash' , [CategoryController::class , 'trash']);
Route::put('categories/{category}/restore' , [CategoryController::class , 'restore']);
Route::delete('categories/{category}/force-delete' , [CategoryController::class , 'forceDelete']);

Route::apiResource('categories' , CategoryController::class);


Route::apiResource('products' , ProductController::class);
