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
        return view('agricola.tareasLote.show', ['tarea' => $tarealote, 'fecha_actual' => $fecha_actual]);
    }

    public function edit(TareasLote $tareaslote)
    {
        return view('agricola.tareasLote.edit',['tarea' => $tareaslote]);
    }
}
