<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SportsPressController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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


Route::post('/loginApi',[ApiAuthController::class,'login'])
    ->name('loginApi');
Route::post('/registerApi',[ApiAuthController::class,'register'])
    ->name('registerApi');
Route::get('/logoutApi',[ApiAuthController::class,'logout'])->name('logoutApi');

Route::get('/register',[AuthController::class,'register'])->name("register");
Route::post('/register',[AuthController::class,'store'])->name("storeUser");

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    $request->user()->level = 1;
    $request->user()->save();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect("/email/verify")->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'login_post'])->name('loginPost');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/profile',[UserController::class,'profile'])->name('profile');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [AuthController::class,'forgetPassword'])->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', [AuthController::class,'resetPassword'])->name('password.update');

Route::get('/{admin?}', function () {
    return view('admin.dashboard');
})->where('admin', 'admin|admin/dashboard')
    ->middleware("auth")->name("dashboard");

Route::prefix("admin")->middleware("auth")->group(function (){

    Route::get("/refund",[PaymentController::class,'refundView'])->name('refundView');
    Route::post("/refund",[PaymentController::class,'refund'])->name("refund");

    Route::prefix("user")->group(function (){
        Route::get('/list',[UserController::class,'list'])->name("userList");
        Route::get('/getUsers',[UserController::class,'getUserData'])->name("getUsers");
        Route::get('/details/{id}',[UserController::class,'userDetails']);
        Route::get('/suspend/{id}',[UserController::class,'suspend'])->name("suspendUser");
        Route::get('/unsuspend/{id}',[UserController::class,'unsuspend'])->name("unsuspendUser");
    });

    Route::prefix("product")->group(function (){
        Route::get('/list',[ProductController::class,'list'])->name("productList");
        Route::get('/getProducts',[ProductController::class,'getProductData'])->name("getProducts");
        Route::get('/create',[ProductController::class,'create'])->name("createProduct");
        Route::post('/store',[ProductController::class,'store'])->name("storeProduct");
        Route::post('/delete',[ProductController::class,'delete'])->name("deleteProduct");
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name("editProduct");
        Route::post('/update/{id}',[ProductController::class,'update'])->name("updateProduct");
    });

    Route::prefix("category")->group(function (){
        Route::get('/create',[CategoryController::class,'create'])->name('createCategory');
        Route::post('/store',[CategoryController::class,'store'])->name("storeCategory");
        Route::get('/getCategories',[CategoryController::class,'getCategoriesData'])->name('getCategories');
        Route::get('/list',[CategoryController::class,'list'])->name('categoryList');
        Route::get('/edit/{id}',[CategoryController::class,'edit']);
        Route::post('/update/{id}',[CategoryController::class,'update'])->name('updateCategory');
        Route::post('/delete',[CategoryController::class,'delete'])->name("deleteCategory");
    });

    Route::prefix("order")->group(function (){
        Route::get('/getOrders',[OrderController::class,'getOrderData'])->name('getOrders');
        Route::get('/list',[OrderController::class,'list'])->name('orderList');
        Route::get('/details/{id}',[OrderController::class,'orderDetails']);
    });

    Route::get('/checkoutWithToken',[CheckoutController::class,'checkoutWithToken'])->name('checkoutWithToken');
    Route::post('/remainingPaymentWithCard',[CheckoutController::class,'remainingPaymentWithCard'])->name("remainingPaymentWithCard");
    Route::get('/ccheckout',[CheckoutController::class,'CardCheckout'])->name("CardCheckout");
});

Route::get('/shop',[ShopController::class,'index'])->name('shop');
Route::get('/detail/{id}',[ShopController::class,'productDetail'])->name('productDetails');

Route::prefix("cart")->group(function (){
    Route::get('/store/{id}',[CartController::class,'store'])->name('cart.store');
    Route::get('/storeSeasonal/{id}',[CartController::class,'storeSeasonal'])->name('cart.storeSeasonal');
    Route::get('/show',[CartController::class,'show'])->name('cart.show');
    Route::post('/update/{id}',[CartController::class,'update'])->name('update');
    Route::get('/delete/{id}',[CartController::class,'delete'])->name('cart.remove');
    Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout')
        ->middleware("auth");
});

Route::prefix("service")->middleware('auth')->group(function (){
    Route::get("/sportspress",[SportsPressController::class,'index'])->name("sportsPress");
    Route::get('/error', function () {
        return view('services.error');
    })->name("service.error");
});
Route::get('cardpayment', [PaymentController::class ,'index'])
    ->middleware("auth")
    ->name("cardPayment");
Route::post('remainingCardpayment', [PaymentController::class ,'remainingPayment'])
    ->middleware("auth")
    ->name("remainingCardPayment");
Route::post('charge', [PaymentController::class,'charge'])->name("charge");
Route::post('remainingcharge', [PaymentController::class,'remainingCharge'])->name("remainingCharge");



