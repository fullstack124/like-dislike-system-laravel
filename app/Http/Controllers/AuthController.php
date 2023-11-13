<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.register');
    }

    function login_view()
    {
        return view('auth.login');
    }


    function create(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return to_route('auth.login');
    }

    function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user=Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($user){
            return to_route('user.post');
        }else{
            return to_route('auth.login');
        }
    }

    function logout(){
        Auth::logout();
        return to_route('auth.login');
    }
}
