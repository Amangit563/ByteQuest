<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserController, ProductController};
use App\Http\Controllers\Web\{WebUserController, WebProductController};
use App\Models\User;
use App\Models\Product;



// ****************************  Public Access Route  ********************************
Route::get('/', function () {
    return view('Login');
})->name('login');

Route::post('/login', [WebUserController::class, 'webLogin'])->name('web.login');


Route::get('/register', function () {
    return view('Register');
});

Route::post('/register', [UserRegisterController::class, 'store'])->name('register.store');




// ****************************  Unauthenticated Person Access Route  ********************************

Route::middleware('auth')->group(function(){

    Route::get('/home', [WebProductController::class, 'dashboard'])->name('home');

    Route::get('/about', function () {
        return view('about');
    });

    // ******************************  Product Show , Create, and  Update  ***************************************

    Route::get('/show_products', [WebProductController::class, 'showAllProducts'])->name('showproducts');

    Route::post('/create_products', [ProductController::class, 'createProduct'])->name('createproducts');

    Route::delete('/product-delete/{id}', [WebProductController::class, 'deleteProduct']);

    Route::get('/product-edit/{id}', [ProductController::class, 'editModalShowData']);
    Route::post('/product-update/{id}', [ProductController::class, 'productUpdate']);

    // ******************************  Product Show , Create, and  Update  ***************************************



    // ****************************  LogOut  ********************************

    Route::get('/logout', [WebUserController::class,'webUserLogout'])->name('logout');

});

