<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Tarea;
use Illuminate\Http\Request;
use App\Models\PlanSemanalFinca;
use App\Models\TareaCosecha;
use App\Models\TareaLoteCosecha;

class TareaCosechaLoteController extends Controller
{
    public function create()
    {
        $planes = PlanSemanalFinca::all();
        $lotes = Lote::all();
        $tareas = TareaCosecha::all();

        return view('agricola.tareasCosechaLote.create',['planes' => $planes, 'lotes' => $lotes, 'tareas' => $tareas]);
    }

    public function tareaCosechaResumen(TareaLoteCosecha $tarealotecosecha)
    {
        return view('agricola.tareasCosechaLote.resumen', compact(['tarealotecosecha']));
    }

}
