<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\Request;

class CultivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cultivos = Cultivo::all();
        return view('agricola.cultivos.index', ['cultivos' => $cultivos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agricola.cultivos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cultivo' => 'required',
                'semanas' => 'required',
            ]);

            Cultivo::create([
                'cultivo' => $request->cultivo,
                'semanas' => $request->semanas,
            ]);
            return redirect()->route('cultivos')->with('success', 'Cultivo creado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Hubo un error al crear el cultivo, intentelo de nuevo más tarde');
        }
    }

    public function edit(Cultivo $cultivo)
    {
        return view('agricola.cultivos.edit', ['cultivo' => $cultivo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cultivo $cultivo)
    {
        $request->validate([
            'cultivo' => 'required',
        ]);

        $cultivo->cultivo = $request->cultivo;
        $cultivo->save();

        return redirect()->route('cultivos')->with('success', 'Cultivo modificado correctamente');
    }
}
