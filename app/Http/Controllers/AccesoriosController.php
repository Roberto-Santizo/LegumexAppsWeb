<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccesoriosController extends Controller
{
    public function create()
    {
        return view('mantenimiento.accesorios.create');
    }
}
