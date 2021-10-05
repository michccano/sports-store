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

    public function CardCheckout()
    {
        $hasMoney = 1;
        $message = null;
        if ($hasMoney !=0){
            $products = Cart::content();
            foreach ($products as $product){
                if ($product->options['category'] == "Memberships"){
                    if ($product->name == "Playbook Playbucks Tokens - 1"){
                        $purchaseTokenQuantity = 1*$product->qty;
                        $this->purchaseTokenService->addToken($purchaseTokenQuantity);
                        $this->bonusTokenService->addToken($product->price, $purchaseTokenQuantity);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 10"){
                        $purchaseTokenQuantity = 10*$product->qty;
                        $this->purchaseTokenService->addToken($purchaseTokenQuantity);
                        $this->bonusTokenService->addToken($product->price, $purchaseTokenQuantity);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 50"){
                        $purchaseTokenQuantity = 50*$product->qty;
                        $this->purchaseTokenService->addToken($purchaseTokenQuantity);
                        $this->bonusTokenService->addToken($product->price, $purchaseTokenQuantity);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 100"){
                        $purchaseTokenQuantity = 100*$product->qty;
                        $this->purchaseTokenService->addToken($purchaseTokenQuantity);
                        $this->bonusTokenService->addToken($product->price, $purchaseTokenQuantity);
                    }
                    elseif ($product->name == "Playbook Playbucks Tokens - 500"){
                        $purchaseTokenQuantity = 500*$product->qty;
                        $this->purchaseTokenService->addToken($purchaseTokenQuantity);
                        $this->bonusTokenService->addToken($product->price, $purchaseTokenQuantity);
                    }
                }
            }
            Cart::destroy();

            return $message = "success";
        }
        else
            return $message = "error";
    }
}
