<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistroTemperaturasController extends Controller
{
    public function index()
    {
        return view('administracion.registrosTEMP.index');
    }

    public function document()
    {
        return view('administracion.registrosTEMP.document');
    }
}
