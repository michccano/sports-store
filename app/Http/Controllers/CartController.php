<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function store($id){
        $product =Product::with('category')->findOrFail($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 0, 'options' => ['img' => $product->img, 'category' => $product->category->name, 'type' => 'single']]);
        $cartCount = Cart::content()->count();
        return response()->json($cartCount);
    }

    public function storeSeasonal($id){
        $product =Product::with('category')->findOrFail($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->weekly_price,
            'weight' => 0, 'options' => ['img' => $product->img, 'category' => $product->category->name, 'type' => 'seasonal']]);
        $cartCount = Cart::content()->count();
        return response()->json($cartCount);
    }

    public function show(){
        $products = Cart::content();
        $hasToken = 0;
        foreach ($products as $product){
            if ($product->options['category'] == "Memberships")
                $hasToken = 1;
        }
        return view('shop.cart',compact("products","hasToken"));
    }

    public function delete($id){
        $products = Cart::content();

        $rowId = $products->where('id',$id)->first()->rowId;
        Cart::remove($rowId);

        $hasToken = 0;
        foreach ($products as $product){
            if ($product->options['category'] == "Memberships")
                $hasToken = 1;
        }
        $cartCount = $products->count();
        return response()->json(['cartCount' => $cartCount , 'hasToken' => $hasToken]);
    }

}
