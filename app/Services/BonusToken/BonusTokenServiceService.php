<?php

namespace App\Services\BonusToken;

use App\Repository\BonusToken\IBonusTokenRepository;
use Illuminate\Support\Facades\Auth;

class BonusTokenServiceService implements IBonusTokenService{

    private $bonusTokenRepository;
    public function __construct(IBonusTokenRepository $bonusTokenRepository){
        $this->bonusTokenRepository = $bonusTokenRepository;
    }

    public function create(){
        $this->bonusTokenRepository->create([
            'total' => 0,
            'user_id' => Auth::id(),
        ]);
    }

    public function getOwnedToken(){
        $bonusToken = $this->bonusTokenRepository->where('user_id',Auth::id())->first();
        if ($bonusToken == null){
            $this->create();
            $bonusToken = $this->bonusTokenRepository->where('user_id',Auth::id())->first();
        }
        return $bonusToken;
    }
}
