<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Tarea;
use App\Models\TareasLote;
use Illuminate\Http\Request;
use App\Models\PlanSemanalFinca;

class TareaLoteController extends Controller
{
    public function create(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $tareas = Tarea::all();
        return view('agricola.tareasLote.create', ['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tareas' => $tareas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $request->validate([
            'personas' => 'required|numeric',
            'presupuesto' => 'required|numeric',
            'horas' => 'required|numeric',
            'tarea_id' => 'required|numeric',
        ]);

        try {
              TareasLote::create([
                'plan_semanal_finca_id' => $plansemanalfinca->id,
                'lote_id' => $lote->id,
                'tarea_id' => $request->tarea_id,
                'personas' => $request->personas,   
                'presupuesto' => $request->presupuesto,
                'horas' => $request->horas,
                'tarifa' => 11.5,
                'cupos' => $request->personas,
                'horas_persona' => ($request->horas)/$request->personas,
            ]);


        return redirect()->route('planSemanal.tareasLote',[$lote,$plansemanalfinca]);
        
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','No se ha podido guardar la tarea');
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
