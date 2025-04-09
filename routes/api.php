<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserController, ProductController};
use App\Http\Controllers\Web\WebProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::group(['prefix' => 'auth' ], function ($router) {

    Route::post('/user/register',[UserController::class, 'userRegister']);
    Route::post('/login',[UserController::class, 'login']);

});


Route::middleware(['auth:api'])->group(function(){
    Route::get('/product-edit/{id}', [ProductController::class, 'editModalShowData']);
    Route::delete('/product-delete/{id}', [WebProductController::class, 'deleteProduct']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/profile', [UserController::class, 'index'])->name('profile');
    Route::post('products', [ProductController::class, 'store']);

});
