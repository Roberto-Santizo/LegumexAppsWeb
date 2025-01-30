<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TareasLote;

class TareaLoteController extends Controller
{
    public function create()
    {
        return view('agricola.tareasLote.create');
    }


    public function show(TareasLote $tarealote)
    {
        $fecha_actual = Carbon::now();
        $tarealote->horas_diferencia = 0;
        try {
            if(!$tarealote->cierresParciales->isEmpty()){
                foreach ($tarealote->cierresParciales as $cierreParcial) {
                    $tarealote->horas_diferencia += $cierreParcial->fecha_inicio->diffInHours($cierreParcial->fecha_final);
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('planSemanal')->with('error','Existe un error al cargar la tarea');
        }
        

        return view('agricola.tareasLote.show', ['tarea' => $tarealote, 'fecha_actual' => $fecha_actual]);
    }

    public function edit(TareasLote $tareaslote)
    {
        return view('agricola.tareasLote.edit',['tarea' => $tareaslote]);
    }
}
