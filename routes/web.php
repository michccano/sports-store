<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
});

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


