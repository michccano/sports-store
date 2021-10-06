<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(){
        if (Auth::check()){
            return back();
        }
        else
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
        session(['link' => url()->previous()]);
        if (Auth::check()){
            return back();
        }
        else
            return view("auth.login");
    }

    public function login_post(LoginRequest $request){
        $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => 1];
        $remember = $request->input('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 1)
                if (session('link') == route("register"))
                    return redirect()->route('dashboard');
                else
                    return redirect(session('link'));
            else{
                if (session('link') == route("register"))
                    return redirect()->route('home');
                else
                    return redirect(session('link'));
            }
        }
        else {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['invalid' => 'Wrong Email or Password']);
        }
    }

    public function forgetPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}
