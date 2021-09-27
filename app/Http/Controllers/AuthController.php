<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class AuthController extends Controller
{
    public function register(){
        return view("auth.register");
    }

    public function store(Request $request){
        $user = User::create([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "address1" => $request->address1,
            "address2" => $request->address2,
            "city" => $request->city,
            "state" => $request->state,
            "postal" => $request->postal,
            "country" => $request->country,
            "dayphone" => $request->dayphone,
            "evephone" => $request->evephone ,
        ]);
        if($user!=null)
            return redirect()->route('login');
        else
            throw new Exception("Cannot Create Account");
    }

    public function login(){
        return view("auth.login");
    }
}
