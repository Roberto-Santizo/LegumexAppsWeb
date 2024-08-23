<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\AsignacionDiaria;
use App\Models\PlanSemanalFinca;

class AsignacionDiariaController extends Controller
{
    public function store(Request $request, Lote $lote, PlanSemanalFinca $plansemanalfinca )
    {
        try {
            AsignacionDiaria::create([
                'tarea_lote_id' => $request->tarealote_id
            ]);
        
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Existe un error al cerrar la asignación diaria');
        }
        
        return redirect()->route('planSemanal.tareasLote',[$lote,$plansemanalfinca])->with('success','Asignación diaria cerrada correctamente');
    }
}
