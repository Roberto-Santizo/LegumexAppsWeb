<?php

namespace App\Http\Controllers;

use App\Models\ControlPlantacion;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class ControlPlantacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cdps = ControlPlantacion::paginate(10);
        return view('agricola.cdps.index', ['cdps' => $cdps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cultivos = Cultivo::all();
        return view('agricola.cdps.create', ['cultivos' => $cultivos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cultivo_id' => 'required',
            'nombre' => 'required',
        ]);

        ControlPlantacion::create([
            'cultivo_id' => $request->cultivo_id,
            'nombre' => $request->nombre,
            'semana' => 1,
        ]);
        return redirect()->route('cdps')->with('success', 'CDP creado correctamente');
    }

}
