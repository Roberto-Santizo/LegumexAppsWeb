<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use App\Models\Lote;
use App\Models\PlanSemanal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;

class PlanSemanalFincasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = PlanSemanalFinca::all();
        return view('agricola.planSemanal.index',['planes' => $planes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fincas = Finca::all();
        return view('agricola.planSemanal.create',['fincas' => $fincas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'finca_id' => 'required',
        ]);

        PlanSemanalFinca::create([
            'finca_id' => $request->finca_id,
            'semana' => Carbon::now()->weekOfYear
        ]);

        return redirect()->route('planSemanal')->with('success','Plan Semanal Creado Correctamente');
    }

    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->finca->lotes;
        return view('agricola.planSemanal.show',['lotes' => $lotes,'planSemanal' => $plansemanalfinca]);
    }

    public function tareasLote(Lote $lote)
    {
        return view('agricola.planSemanal.tareasLote',['lote' => $lote]);
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
