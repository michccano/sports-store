<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SportsPressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name("home");

Route::get('/register',[AuthController::class,'register']);
Route::post('/register',[AuthController::class,'store'])->name("storeUser");
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'login_post'])->name('loginPost');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::prefix("admin")->middleware("auth")->group(function (){
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name("dashboard");
    Route::prefix("product")->group(function (){
        Route::get('/list',[ProductController::class,'list'])->name("productList");
        Route::get('/create',[ProductController::class,'create'])->name("createProduct");
        Route::post('/store',[ProductController::class,'store'])->name("storeProduct");
        Route::get('/delete',[ProductController::class,'delete'])->name("deleteProduct");
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name("editProduct");
        Route::post('/update/{id}',[ProductController::class,'update'])->name("updateProduct");
    });

});

Route::get('/shop',[ShopController::class,'index'])->name('shop');
Route::prefix("cart")->group(function (){
    Route::post('/store',[CartController::class,'store'])->name('cart.store');
    Route::get('/show',[CartController::class,'show'])->name('cart.show');
    Route::post('/delete',[CartController::class,'delete'])->name('cart.remove');
    Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout')
        ->middleware("auth");
});
Route::get("/sportspress",[SportsPressController::class,'index'])->middleware("auth");
Route::get('/error', function () {
    return view('services.error');
})->name("service.error");



