<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store($id){
        $product =Product::with('category')->findOrFail($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 0, 'options' => ['img' => $product->img, 'category' => $product->category->name]]);
        $cartCount = Cart::content()->count();
        return response()->json($cartCount);
    }

    public function show(){
        $products = Cart::content();
        return view('shop.cart',compact("products"));
    }

    public function delete($id){
        $product = Cart::content()->where('id',$id)->first();
        $rowId = $product->rowId;
        Cart::remove($rowId);
        $cartCount = Cart::content()->count();
        return response()->json($cartCount);
    }

    public function checkout(){
        $payment = Cart::total();

        $user = User::with('purchaseToken','bonusToken','makeupToken')->find(Auth::id());
        $userToken = $user->token;
        $tokenLeft = $userToken - $payment;
        if($tokenLeft >=0){
            Cart::destroy();
            $user->token = $tokenLeft;
            $user->save();
            return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
        }
        else{
            return redirect()->route('cart.show')->with("errorMessage","Don't Have Enough Token");
        }
    }
}
