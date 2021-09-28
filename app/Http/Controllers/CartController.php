<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store($id){
        $product =Product::findOrFail($id);

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 0, 'options' => ['img' => $product->img]]);

        return redirect()->route('shop')->with("message","Added To Cart");
    }

    public function show(){
        $products = Cart::content();
        return view('shop.cart',compact("products"));
    }

    public function delete(Request $request){
        $rowId = $request->rowId;
        Cart::remove($rowId);
        return redirect()->route('cart.show');
    }

    public function checkout(){
        $payment = Cart::total();

        $user = Auth::user();
        $userToken = $user->token;
        $tokenLeft = $userToken - $payment;
        if($tokenLeft >=0){
            Cart::destroy();
            $user->token = $tokenLeft;
            $user->save();
            return redirect()->route('shop')->with("message","Order Placed Successfully");
        }
        else{
            return redirect()->route('cart.show')->with("message","Don't Have Enough Token");
        }
    }
}
