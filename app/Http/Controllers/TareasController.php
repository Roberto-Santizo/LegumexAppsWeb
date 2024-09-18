<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Etapa;
use App\Models\Finca;
use App\Models\Tarea;
use App\Models\TareaEtapa;
use Illuminate\Http\Request;
use App\Models\BitacoraTareas;
use Illuminate\Support\Facades\DB;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::paginate(10);
        return view('agricola.tareas.index', ['tareas' => $tareas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agricola.tareas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
            $request->validate([
                'tarea' => 'required',
                'descripcion' => 'required|max:255',
                'code' => 'required'
            ]);

            Tarea::create([
                'tarea' => $request->tarea,
                'descripcion' => $request->descripcion,
                'code' => $request->code,
            ]);

            return redirect()->route('tareas')->with('success', 'Tarea creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return view('agricola.tareas.show', ['tarea' => $tarea]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        return view('agricola.tareas.edit', ['tarea' => $tarea]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        try {
            $request->validate([
                'tarea' => 'required',
                'descripcion' => 'required|max:255',
                'code' => 'required',
            ]);

            $tarea->update([
                'tarea' => $request->tarea,
                'descrpcion' => $request->descripcion,
                'code' => $request->code,
            ]);
            return redirect()->route('tareas')->with('success', 'Tarea modificada correctamente');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'Hubo un error al modificar la tarea, vuelva a intentarlo más tarde');
        }
    }
}
