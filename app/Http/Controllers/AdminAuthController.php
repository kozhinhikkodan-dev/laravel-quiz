<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    //

    public function login(){
        return view('pages.login');
    }

    public function loginProcess(Request $request){


        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if(!Auth::guard('admin')->attempt($request->only('email', 'password'), $request->remember)){
            return back()->with('login-error', 'Invalid login details');
        }

        $user = Auth::guard('admin')->user();
        session()->put('user', $user);
        session()->put('role', 'admin');
        session()->put('locale', $user->lang);

        return redirect()->route('home')->with('success', 'Welcome. You are now logged in.');
    }

    public function register(){
        return view('pages.register');
    }

    public function registerProcess(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Your account has been created successfully. Please login to continue.');
    }


    public function logout(Request $request){
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }

}
