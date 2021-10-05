<?php

namespace App\Services\User;

use App\Repository\User\IUserRepository;
use Illuminate\Support\Facades\Auth;

class UserService implements IUserService{

    private $userRepository;

    public function __construct(IUserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getUserWithTokenRelationships(){
        return $this->userRepository->with('purchaseToken','bonusToken','makeupToken')
            ->find(Auth::id());
    }
}
