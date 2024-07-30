<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index(){
        $auntenticado = session('access_token') ? true : false;
        if(!session('access_token')){
            return redirect()->route('home');
        }
        return view('auth.login', ['autenticado' => $auntenticado]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'username' => 'required|min:6',
            'password' => 'required',
        ]);
        
        if(!auth()->attempt($request->only('username','password'),$request->remember)){
            return back()->with('error', 'Credenciales incorrectas');
        }

        return redirect()->route('dashboard');
    }
}
