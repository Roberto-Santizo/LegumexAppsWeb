<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquiposController extends Controller
{
    public function index()
    {
        return view('mantenimiento.equipos.index');
    }

    public function create()
    {
        return view('mantenimiento.equipos.create');
    }

    public function show(Equipo $equipo) 
    {
        return view('mantenimiento.equipos.show',compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        return view('mantenimiento.equipos.edit',compact('equipo'));
    }
}
