<?php

namespace App\Services\BonusToken;

interface IBonusTokenService{
    public function create();
    public function getOwnedToken();
}
