<?php

namespace App\Services\User;

use App\Repository\User\IUserRepository;
use App\Services\BonusToken\IBonusTokenService;
use App\Services\MakeupToken\IMakeupTokenService;
use App\Services\Order\IOrderService;
use App\Services\PurchaseToken\IPurchaseTokenService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class UserService implements IUserService{

    private $userRepository;
    private $orderService;
    private $purchaseTokenService;
    private $bonusTokenService;
    private $makeupTokenService;

    public function __construct(IUserRepository $userRepository,
                                IOrderService $orderService,
                                IPurchaseTokenService $purchaseTokenService,
                                IBonusTokenService $bonusTokenService,
                                IMakeupTokenService $makeupTokenService){
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
        $this->purchaseTokenService = $purchaseTokenService;
        $this->bonusTokenService = $bonusTokenService;
        $this->makeupTokenService = $makeupTokenService;

    }

    public function getUserWithTokenProductRelationships(){
        $user = $this->userRepository->with('purchaseToken','bonusToken','makeupToken','products')
            ->find(Auth::id());
        if ($user->purchaseToken == null)
            $this->purchaseTokenService->create();
        if ($user->bonusToken == null)
            $this->bonusTokenService->create();
        if ($user->makeupToken == null)
            $this->makeupTokenService->create();
        return $user;
    }

    public function createGuestUser($request, $payment, $invoice, $message_code, $transactionId, $cardNumber){
        $user = $this->userRepository->where("email",$request['email'])->first();

        if ($user == null){

           $user = $this->userRepository->create([
                "firstname" => $request['firstname'],
                "lastname" => $request['lastname'],
                "email" => $request['email'],
                "password" => bcrypt("12345678"),
                "address1" => $request['address'],
                "city" => $request['city'],
                "state" => $request['state'],
                "postal" => $request['postal'],
                "country" => $request['country'],
                "dayphone" => $request['phone'],
            ]);
        }
        else{
            $this->updateGuestUser($user->id,$request);
        }
        $this->orderService->create(0 , $payment, $invoice, $message_code, $transactionId, $cardNumber,$user);
        Cart::destroy();
    }

    public function updateGuestUser($id,$request){
        $this->userRepository->updateById($id ,[
            "firstname" => $request['firstname'],
            "lastname" => $request['lastname'],
            "email" => $request['email'],
            "password" => bcrypt("12345678"),
            "address1" => $request['address'],
            "city" => $request['city'],
            "state" => $request['state'],
            "postal" => $request['postal'],
            "country" => $request['country'],
            "dayphone" => $request['phone'],
        ]);
    }
}
