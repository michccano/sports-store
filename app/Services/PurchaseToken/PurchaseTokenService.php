<?php

namespace App\Services\PurchaseToken;

use App\Repository\PurchaseToken\IPurchaseTokenRepository;
use Illuminate\Support\Facades\Auth;

class PurchaseTokenService implements IPurchaseTokenService{

    private $purchaseTokenRepository;
    public function __construct(IPurchaseTokenRepository $purchaseTokenRepository){
        $this->purchaseTokenRepository =$purchaseTokenRepository;
    }

    public function create(){
        $this->purchaseTokenRepository->create([
            'total' => 0,
            'user_id' => Auth::id(),
        ]);
    }

    public function getOwnedToken(){
        $purchaseToken = $this->purchaseTokenRepository->where('user_id',Auth::id())->first();
        if ($purchaseToken == null){
            $this->create();
            $purchaseToken = $this->purchaseTokenRepository->where('user_id',Auth::id())->first();
        }
        return $purchaseToken;
    }

    public function addToken($tokenQuantity){
        $purchaseToken = $this->getOwnedToken();
        $purchaseToken->total += $tokenQuantity;
        $purchaseToken->save();
    }
}
