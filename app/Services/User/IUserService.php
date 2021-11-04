<?php

namespace App\Services\User;

interface IUserService{
    public function getUserWithTokenRelationships();
    public function createGuestUser($request, $payment, $invoice, $message_code, $transactionId, $cardNumber);
}
