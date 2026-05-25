<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index(){
        return view('admin.auth.login');
    }
    public function authenticate(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password,
        ])){
            $request->session()->regenerate();

            if(Auth::user()->role=='admin'){
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            return redirect()->back()->with('error','Access Denied');
        }

        return redirect()->back()->with('error','Invalid Email or Password');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
