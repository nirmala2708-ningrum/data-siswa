<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auths.login');
    }
    public function postlogin(Request $request)
   {
    if(Auth::attempt($request->only('email','password'))){
        return redirect('/siswa');
}
    return redirect('/login');
   }

   public function logout()
   {
    Auth::logout();
    return view('auths.login');
   }
}
