<?php

namespace App\Http\Controllers;

use App\Models\BonusToken;
use App\Models\PurchaseToken;
use App\Models\User;
use App\Services\Checkout\ICheckoutService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private $checkoutService;
    public function __construct(ICheckoutService $checkoutService){
        $this->checkoutService = $checkoutService;
    }
    public function checkoutWithToken(){

        $payment = Cart::total();
        $user = User::with('purchaseToken','bonusToken','makeupToken')
            ->find(Auth::id());
        $userTotalToken = $user->purchaseToken->total + $user->bonusToken->total;
        $remainingPayment = $this->checkoutService->checkoutWithToken();

        if ($remainingPayment != null){
            if($remainingPayment == 0){
                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            }
            else{
                return view("checkout.remainingCardPayment",compact("payment","remainingPayment","userTotalToken"));
            }
        }
    }

    public function remainingPaymentWithCard(){
        $message = $this->checkoutService->remainingPaymentWithCard();

        if ($message != null){
            if ($message == "success"){

                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            }
            else{
                return redirect()->route('cart.show')->with("errorMessage","You Don't Have Enough Money");
            }
        }
    }

    public function CardCheckout(){
        $hasMoney = 1;
        $purchaseToken = PurchaseToken::where('user_id',Auth::id())->first();
        if ($purchaseToken == null){
            PurchaseToken::create([
                'total' => 0,
                'user_id' => Auth::id(),
            ]);
            $purchaseToken = PurchaseToken::where('user_id',Auth::id())->first();
        }
        $bonusToken = BonusToken::where('user_id',Auth::id())->first();
        if ($bonusToken == null){
            BonusToken::create([
                'total' => 0,
                'user_id' => Auth::id(),
            ]);
            $bonusToken = BonusToken::where('user_id',Auth::id())->first();
        }
        if ($hasMoney !=0){
            $products = Cart::content();
            foreach ($products as $product){
                if ($product->options['category'] == "Memberships"){
                    if ($product->name == "Playbook Playbucks Tokens - 1"){
                        $purchaseTokenQuantity = 1*$product->qty;
                        $purchaseToken->total += $purchaseTokenQuantity;
                        if ($product->price >= 5)
                            $bonusToken->total += (integer)(($purchaseTokenQuantity*20)/100);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 10"){
                        $purchaseTokenQuantity = 10*$product->qty;
                        $purchaseToken->total += $purchaseTokenQuantity;
                        if ($product->price >= 5)
                            $bonusToken->total += (integer)(($purchaseTokenQuantity*20)/100);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 50"){
                        $purchaseTokenQuantity = 50*$product->qty;
                        $purchaseToken->total += $purchaseTokenQuantity;
                        if ($product->price >= 5)
                            $bonusToken->total += (integer)(($purchaseTokenQuantity*20)/100);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 100"){
                        $purchaseTokenQuantity = 100*$product->qty;
                        $purchaseToken->total += $purchaseTokenQuantity;
                        if ($product->price >= 5)
                            $bonusToken->total += (integer)(($purchaseTokenQuantity*20)/100);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 500"){
                        $purchaseTokenQuantity = 500*$product->qty;
                        $purchaseToken->total += $purchaseTokenQuantity;
                        if ($product->price >= 5)
                            $bonusToken->total += (integer)(($purchaseTokenQuantity*20)/100);
                    }
                }
                $purchaseToken->save();
                $bonusToken->save();
            }
            Cart::destroy();

            return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
        }
        else{
            return redirect()->route('cart.show')->with("errorMessage","You Don't Have Enough Money");
        }
    }
}
