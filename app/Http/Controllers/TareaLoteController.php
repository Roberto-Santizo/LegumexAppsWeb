<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Tarea;
use App\Models\TareasLote;
use Illuminate\Http\Request;
use App\Models\PlanSemanalFinca;

class TareaLoteController extends Controller
{
    public function create()
    {
        $tareas = Tarea::all();
        $planes = PlanSemanalFinca::orderBy('semana','DESC')->get();
        $lotes = Lote::all();
        return view('agricola.tareasLote.create', ['tareas' => $tareas,'planes' => $planes,'lotes' => $lotes]);
    }

 
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
                'cupos' => $request->personas,
                'horas_persona' => ($request->horas)/$request->personas,
            ]);


        return redirect()->route('planSemanal.tareasLote',[$lote,$plansemanalfinca]);
        
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','No se ha podido guardar la tarea');
        }
        
    }

    public function edit(TareasLote $tareaslote)
    {
        return view('agricola.tareasLote.edit',['tarea' => $tareaslote]);
    }
}
