<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class AuthController extends Controller
{
    public function register(){
        return view("auth.register");
    }

    public function store(RegisterRequest $request){
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

    public function login_post(LoginRequest $request){
        $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => 1];
        $remember = $request->input('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 1)
            return redirect()->route('dashboard');
            else{
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors(['invalid' => 'You are not an admin']);
            }
        }
        else {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['invalid' => 'Wrong Email or Password']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}
