<?php

namespace App\Services\PurchaseToken;

interface IPurchaseTokenService{
    public function create();
    public function getOwnedToken();
}
