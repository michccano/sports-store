<?php

namespace App\Services\Checkout;

interface ICheckoutService{
    public function checkoutWithToken();
    public function remainingPaymentWithCard($payment, $remainingPayment, $invoice, $transactionReference, $transactionId, $cardNumber);
    public function CardCheckout($invoice, $transactionReference, $transactionId, $cardNumber);
}
