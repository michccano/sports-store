<?php

namespace App\Services\MakeupToken;

use App\Repository\MakeupToken\IMakeupTokenRepository;
use Illuminate\Support\Facades\Auth;

class MakeupTokenService implements IMakeupTokenService{

    private $makeupTokenRepository;
    public function __construct(IMakeupTokenRepository $makeupTokenRepository){
        $this->makeupTokenRepository = $makeupTokenRepository;
    }

    public function create(){
        $this->makeupTokenRepository->create([
            'total' => 0,
            'user_id' => Auth::id(),
        ]);
    }

}
