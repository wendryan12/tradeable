<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;



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

Route::group(['prefix'=>'auth'], function() {
     Route::post('/login' , [AuthController::class, 'login']);
     Route::post('/register' , [AuthController::class,'register']);
});

Route::group(['prefix'=>'profile'] , function() {
    Route::get('/{id}' , [ProfileController::class,'getUserProfile']);
    Route::put('/update/{id}', [ProfileController::class,'updateProfile']);
});

Route::group(['prefix'=>'product'] , function() {
    Route::get('/all', [ProductController::class,'getAllProduct']);
    Route::get('/{id}' ,[ProductController::class,'detailProduct']);
    Route::post('/create' , [ProductController::class,'createProduct']);
    Route::delete('/delete/{id}', [ProductController::class,'deleteProduct']);
    Route::post("/update/{id}" , [ProductController::class, 'updateProduct']);
}); 

Route::group(['prefix'=>'cart'] , function() {
   Route::post('/create',[CartController::class,'createCart'])  ;
   Route::get('/all' , [CartController::class,'getUserCarts']);
   Route::delete('/delete/{id}' , [CartController::class,'deleteCart']);
});