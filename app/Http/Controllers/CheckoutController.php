<?php

namespace App\Http\Controllers;

use App\Services\Checkout\ICheckoutService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;;

class CheckoutController extends Controller
{
    private $checkoutService;
    public function __construct(ICheckoutService $checkoutService){
        $this->checkoutService = $checkoutService;
    }
    public function checkoutWithToken(){

        $payment = Cart::total();
        $remainingPayment = $this->checkoutService->checkoutWithToken();
            if($remainingPayment == 0){
                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            }
            else{
                return view("checkout.remainingCardPayment",compact("payment","remainingPayment"));
            }
    }

    public function remainingPaymentWithCard(Request $request){
        $message = $this->checkoutService->remainingPaymentWithCard($request->payment,$request->remainingPayment);

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
        $message = $this->checkoutService->CardCheckout();

        if ($message != null){
            if ($message == "success"){

                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            }
            else{
                return redirect()->route('cart.show')->with("errorMessage","You Don't Have Enough Money");
            }
        }
    }
}
