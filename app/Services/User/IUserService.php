<?php

namespace App\Services\User;

interface IUserService{
    public function getUserWithTokenProductRelationships();
    public function createGuestUser($request, $payment, $invoice, $message_code, $transactionId, $cardNumber);
}
