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
        return view('agricola.tareasCosechaLote.create');
    }

    public function tareaCosechaResumen(TareaLoteCosecha $tarealotecosecha)
    {
        return view('agricola.tareasCosechaLote.resumen', compact(['tarealotecosecha']));
    }

}
