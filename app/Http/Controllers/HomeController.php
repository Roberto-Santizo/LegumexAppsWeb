<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {      
        $accessToken = session('access_token');
        $isAuthenticated = $accessToken ? true : false;

        return view('home', ['autenticado' => $isAuthenticated]);
    }
}
