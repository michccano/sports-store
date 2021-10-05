<?php

namespace App\Services\Checkout;

use App\Models\User;
use App\Services\BonusToken\IBonusTokenService;
use App\Services\PurchaseToken\IPurchaseTokenService;
use App\Services\User\IUserService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutService implements ICheckoutService{
    private $userService;
    private $purchaseTokenService;
    private $bonusTokenService;

    public function __construct(
                                IPurchaseTokenService $purchaseTokenService,
                                IBonusTokenService $bonusTokenService)
    {

        $this->purchaseTokenService = $purchaseTokenService;
        $this->bonusTokenService = $bonusTokenService;
    }

    public function checkoutWithToken()
    {
        $payment = Cart::total();
        $user = User::with('purchaseToken','bonusToken','makeupToken')
            ->find(Auth::id());
        $userTotalToken = $user->purchaseToken->total + $user->bonusToken->total;
        $remainingPayment = null;
        $tokenLeft = $userTotalToken- $payment;
        if($tokenLeft >=0){
            Cart::destroy();
            $purchaseToken = $this->purchaseTokenService->getOwnedToken();
            $purchaseToken->total = $tokenLeft;
            $bonusToken = $this->bonusTokenService->getOwnedToken();
            $bonusToken->total = 0;
            $purchaseToken->save();
            $bonusToken->save();
            return $remainingPayment = 0;
        }
        else{
            return $remainingPayment = $payment - $userTotalToken;
        }
    }

    public function remainingPaymentWithCard()
    {
        $hasMoney = rand(0, 1);
        $message = null;
        if ($hasMoney !=0){
            Cart::destroy();
            $purchaseToken = $this->purchaseTokenService->getOwnedToken();
            $purchaseToken->total = 0;
            $bonusToken = $this->bonusTokenService->getOwnedToken();
            $bonusToken->total = 0;
            $purchaseToken->save();
            $bonusToken->save();
            return $message = "success";
        }
        else
            return $message = "error";
    }
}
