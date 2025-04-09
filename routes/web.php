<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserController, ProductController};
use App\Http\Controllers\Web\{WebUserController, WebProductController};
use App\Models\User;
use App\Models\Product;

Route::get('/', function () {
    return view('Login');
})->name('login');

Route::post('/login', [WebUserController::class, 'webLogin'])->name('web.login');


Route::get('/register', function () {
    return view('Register');
});

Route::post('/register', [UserRegisterController::class, 'store'])->name('register.store');

Route::get('/about', function () {
    return view('about');
});


Route::middleware('auth')->group(function(){

    Route::get('/show_products', [WebProductController::class, 'showAllProducts'])->name('showproducts');

    Route::post('/create_products', [ProductController::class, 'createProduct'])->name('createproducts');

    Route::get('/home', [WebProductController::class, 'dashboard'])->name('home');

    Route::delete('/product-delete/{id}', [WebProductController::class, 'deleteProduct']);

    Route::get('/product-edit/{id}', [ProductController::class, 'editModalShowData']);
    Route::post('/product-update/{id}', [ProductController::class, 'update'])->name('product.update');
});

