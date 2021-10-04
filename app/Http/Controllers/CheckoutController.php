<?php

namespace App\Http\Controllers;

use App\Models\BonusToken;
use App\Models\PurchaseToken;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkoutWithToken(){
        $payment = Cart::total();

        $user = User::with('purchaseToken','bonusToken','makeupToken')->find(Auth::id());
        $userTotalToken = $user->purchaseToken->total + $user->bonusToken->total;

        $tokenLeft = $userTotalToken- $payment;
        if($tokenLeft >=0){
            Cart::destroy();
            $purchaseToken = PurchaseToken::where('user_id',Auth::id())->first();
            $purchaseToken->total = $tokenLeft;
            $bonusToken = BonusToken::where('user_id',Auth::id())->first();
            $bonusToken->total = 0;
            $purchaseToken->save();
            $bonusToken->save();
            return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
        }
        else{
            $remainingPayment = $payment - $userTotalToken;
            return view("checkout.remainingCardPayment",compact("payment","remainingPayment","userTotalToken"));
        }
    }
}
