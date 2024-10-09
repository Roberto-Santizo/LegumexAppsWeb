<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Tarea;
use Illuminate\Http\Request;
use App\Models\PlanSemanalFinca;

class TareaCosechaLoteController extends Controller
{
    public function create()
    {
        $planes = PlanSemanalFinca::all();
        $lotes = Lote::all();
        $tareas = Tarea::where('tarea','like','%cosecha%')->get();

        return view('agricola.tareasCosechaLote.create',['planes' => $planes, 'lotes' => $lotes, 'tareas' => $tareas]);
    }
}
