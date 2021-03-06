<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store($id){
        $product =Product::with('category')->findOrFail($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->weekly_price,
            'weight' => 0, 'options' => ['img' => $product->img, 'category' => $product->category->name, 'type' => 'single']]);
        $cartCount = Cart::content()->count();
        return response()->json($cartCount);
    }

    public function storeRemainingToken(Request $request){
        $product =Product::with('category')->where("name","Playbook Playbucks Tokens - 1")->first();
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->remainingPayment,
            'price' => $product->weekly_price,
            'weight' => 0, 'options' => ['img' => $product->img, 'category' => $product->category->name, 'type' => 'single']]);
        return redirect()->route('cart.show');
    }

    public function storeSeasonal($id){
        $product =Product::with('category')->findOrFail($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 0, 'options' => ['img' => $product->img, 'category' => $product->category->name, 'type' => 'seasonal']]);
        $cartCount = Cart::content()->count();
        return response()->json($cartCount);
    }

    public function show(){
        $products = Cart::content();
        $hasToken = 0;
        foreach ($products as $product){
            if ($product->options['category'] == "Memberships" || $product->options['category'] == "Tokens")
                $hasToken = 1;
        }
        return view('shop.cart',compact("products","hasToken"));
    }

    public function update($id, Request $request){
        $products = Cart::content();
        $product = $products->where('id',$id)->first();
        $rowId = $product->rowId;
        Cart::update($rowId, $request->qty);
        $price = $product->price * $product->qty;
        return response()->json($price);
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
