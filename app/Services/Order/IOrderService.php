<?php

namespace App\Services\Order;

interface IOrderService{
    public function create($tokenBill , $cardBill, $invoice, $message_code, $transactionId, $cardNumber);
    public function addOrderProduct($order);
}
