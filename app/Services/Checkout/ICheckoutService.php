<?php

namespace App\Services\Checkout;

interface ICheckoutService{
    public function checkoutWithToken();
    public function remainingPaymentWithCard();
    public function CardCheckout();
}
