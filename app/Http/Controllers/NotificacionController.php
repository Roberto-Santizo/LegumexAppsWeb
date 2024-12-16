<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        // $token = session('token');

        // if(!$token){
        //     return redirect()->route('dashboard');
        // }
        return view('notificacion.index');
    }
}
