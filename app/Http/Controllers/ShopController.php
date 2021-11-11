<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Carbon;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::query()->where("status", 1)->get();
        $cart = Cart::content();
        return view('shop.shop', compact("products", "categories", "cart"));
    }

    public function productDetail($id)
    {
        $product = Product::query()->findOrFail($id);
        $cart = Cart::content();
        return view('shop.productDetails', compact("product", "cart"));
    }
}
