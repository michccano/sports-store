<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $products = Product::where("status",1)->get();
        $cart = Cart::content();
        return view('shop.productList',compact("products","cart"));
    }
}
