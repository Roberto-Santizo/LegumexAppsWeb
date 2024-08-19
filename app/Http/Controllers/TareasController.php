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
        $tareas = Tarea::paginate(5);
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
        try {
            DB::transaction(function () use ($request) {
                $request->validate([
                    'tarea' => 'required',
                    'descripcion' => 'required|max:255',
                ]);

                Tarea::create([
                    'tarea' => $request->tarea,
                    'descripcion' => $request->descripcion,
                ]);

            });

            return redirect()->route('tareas')->with('success', 'Tarea creada correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Hubo un error al crear la tarea');
        }
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
            DB::transaction(function () use ($request, $tarea) {

                $request->validate([
                    'tarea' => 'required',
                    'descripcion' => 'required|max:255',
                    'tarifa' => 'required',
                    'horas_totales' => 'required',
                    'presupuesto' => 'required',
                    'personas' => 'required',
                ]);

                BitacoraTareas::create([
                    'tarea_id' => $tarea->id,
                    'personas_nuevo' => $request->personas,
                    'personas_anterior' => $tarea->personas,
                    'horas_nueva' => $request->horas_totales,
                    'horas_anterior' => $tarea->horas_totales,
                    'tarifa_nueva' => $request->tarifa,
                    'tarifa_anterior' => $tarea->tarifa,
                    'presupuesto_nuevo' => $request->presupuesto,
                    'presupuesto_anterior' => $tarea->presupuesto,
                    'descripcion_nuevo' => $request->descripcion,
                    'descripcion_anterior' => $tarea->descripcion,
                    'titulo_nuevo' => $request->tarea,
                    'titulo_anterior' => $tarea->tarea,
                    'semana' => Carbon::now()->weekOfYear
                ]);

                $tarea->update([
                    'tarea' => $request->tarea,
                    'descrpcion' => $request->descripcion,
                    'tarifa' => $request->tarifa,
                    'horas_totales' => $request->horas_totales,
                    'personas' => $request->personas,
                    'presupuesto' => $request->presupuesto,
                ]);
            });
            return redirect()->route('tareas')->with('success', 'Tarea modificada correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', 'Hubo un error al modificar la tarea, vuelva a intentarlo más tarde');
        }
    }

    public function historial()
    {
        $cambios = BitacoraTareas::paginate(10);
        return view('agricola.tareas.historial', ['cambios' => $cambios]);
    }
}
