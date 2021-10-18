<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $expired_products = Product::where('expire_date', '<=', Carbon::now())->get();
        foreach ($expired_products as $product){
            $product->status = 0;
            $product->save();
        }
        $products = Product::where("status",1)->get();
        $cart = Cart::content();
        return view('shop.shop',compact("products","cart"));
    }

    public function productDetail($id){
        $product = Product::findOrFail($id);
        $cart = Cart::content();
        return view('shop.productDetails',compact("product","cart"));
    }
}
