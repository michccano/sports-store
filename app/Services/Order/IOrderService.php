<?php

namespace App\Services\Order;

interface IOrderService{
    public function create($tokenBill , $cardBill, $invoice, $message_code, $transactionId, $cardNumber, $user);
    public function addOrderProduct($order,$user);
}
