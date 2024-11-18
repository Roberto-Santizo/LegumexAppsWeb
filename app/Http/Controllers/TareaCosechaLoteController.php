<?php

namespace App\Http\Controllers;

use App\Models\TareaLoteCosecha;

class TareaCosechaLoteController extends Controller
{
    public function create()
    {
        return view('agricola.tareasCosechaLote.create');
    }

    public function tareaCosechaResumen(TareaLoteCosecha $tarealotecosecha)
    {
        return view('agricola.tareasCosechaLote.resumen', compact(['tarealotecosecha']));
    }

    public function show(TareaLoteCosecha $tarealotecosecha)
    {
        $asignacion = $tarealotecosecha->asignacionDiaria;
        $empleadosAsignados = $tarealotecosecha->users()->whereDate('created_at',$asignacion->created_at)->get();
        return view('agricola.tareasCosechaLote.show',compact('tarealotecosecha','empleadosAsignados','asignacion'));
    }

}
