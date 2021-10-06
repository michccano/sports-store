<?php

namespace App\Services\Order;

interface IOrderService{
    public function create($tokenBill , $cardBill);
    public function addOrderProduct($order);
}
