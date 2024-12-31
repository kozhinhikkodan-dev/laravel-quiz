<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(){
        return view('pages.login');
    }

    public function loginProcess(Request $request){

        // dd($request->all());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if(!Auth::attempt($request->only('email', 'password'), $request->remember)){
            return back()->with('login-error', 'Invalid login details');
        }

        // add user data as user into session
        $user = Auth::user();
        session()->put('user', $user);
        session()->put('role', 'user');
        session()->put('locale', $user->lang);


        return redirect()->route('home')->with('success', 'Welcome. You are now logged in.');
    }

    public function register(){
        return view('pages.register');
    }

    public function registerProcess(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Your account has been created successfully. Please login to continue.');
    }


    public function logout(Request $request){

        $guards = config('auth.guards');
        foreach ($guards as $guard => $value) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }
            $request->session()->flush();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

}
