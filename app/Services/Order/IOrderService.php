<?php

namespace App\Services\Order;

interface IOrderService{
    public function create($tokenBill , $cardBill, $invoice, $transactionReference, $transactionId, $cardNumber);
    public function addOrderProduct($order);
}
