<?php

namespace App\Services\PurchaseToken;

interface IPurchaseTokenService{
    public function create();
    public function getOwnedToken();
    public function addToken($tokenQuantity);
}
