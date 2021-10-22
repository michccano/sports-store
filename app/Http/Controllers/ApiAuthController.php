<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ApiAuthController extends Controller
{
    public function register(RegisterRequest $request){
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
        {
            Auth::login($user);
            $request->session()->regenerate();
            event(new Registered($user));
            return response()->json("Registration complete succesfully");
        }
        else
            throw new Exception("Cannot Create Account");
    }
    public function login(LoginRequest $request){
        $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => 1];
        $remember = $request->input('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 1)
                return response()->json("admin logged in");
            else{
                return response()->json("user logged in");
            }
        }
        else {
            return response()->json("Wrong email or password");
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json("logged out");
    }
}
