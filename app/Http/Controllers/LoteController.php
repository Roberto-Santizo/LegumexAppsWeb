<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Finca;
use App\Models\Cultivo;
use Illuminate\Http\Request;
use App\Models\BitacoraLotes;
use App\Models\ControlPlantacion;
use Illuminate\Support\Facades\DB;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lotes = Lote::paginate(10);
        return view('agricola.lotes.index',['lotes' => $lotes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cdps = ControlPlantacion::all();
        $fincas = Finca::all();
        return view('agricola.lotes.create', ['cdps' => $cdps, 'fincas' => $fincas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'finca_id' => 'required',
        ]);

        Lote::create([
            'nombre' => $request->nombre,
            'finca_id' => $request->finca_id,
            'estado' => 1
        ]);

        return redirect()->route('lotes')->with('success', 'Lote creado correctamente');
    }

    public function consultaLotes()
    {
        return view('agricola.lotes.consulta');
    }

    // public function edit(Lote $lote)
    // {
    //     $cdps = ControlPlantacion::all();
    //     return view('agricola.lotes.edit', ['lote' => $lote, 'cdps' => $cdps]);
    // }

    // public function update(Request $request, Lote $lote)
    // {
    //     try {
    //         DB::transaction(function () use ($request, $lote) {

    //             $request->validate([
    //                 'cdp_id' => 'required',
    //             ]);

    //             BitacoraLotes::create([
    //                 'lote_id' => $lote->id,
    //                 'cdp_anterior' => $lote->cdp_id,
    //                 'cdp_nuevo' => $request->cdp_id,
    //                 'estado_anterior' => $lote->estado,
    //                 'estado_nuevo' => $lote->estado,
    //                 'semana_cambio' => Carbon::now()->weekOfYear,
    //             ]);

    //             $lote->cdp_id = $request->cdp_id;
    //             $lote->save();

    //         });
            
    //         return redirect()->route('lotes')->with('success', 'Lote modificado correctamente');
    //     } catch (\Throwable $th) {
    //         return back()->with('error', 'Error al actualizar el lote, vuelva a intentarlo más tarde');
    //     }
    // }

    // public function destroy(Lote $lote)
    // {
    //     try {
    //         DB::transaction(function () use ($lote) {
                
    //             BitacoraLotes::create([
    //                 'lote_id' => $lote->id,
    //                 'cdp_anterior' => $lote->cdp_id,
    //                 'cdp_nuevo' => $lote->cdp_id,
    //                 'estado_anterior' => ($lote->estado == 1) ? 1 : 0,
    //                 'estado_nuevo' => ($lote->estado == 1) ? 0 : 1,
    //                 'semana_cambio' => Carbon::now()->weekOfYear,
    //             ]);

    //             if($lote->estado == 0){
    //                 $lote->estado = 1;
    //             }else{
    //                 $lote->estado = 0;
    //             }
    
    //             $lote->save();
    //         });

    //         return redirect()->route('lotes')->with('success','Lote modificado correctamente');
    //     } catch (\Throwable $th) {
    //         return back()->with('error','Hubo un error al modificar el lote, intentelo de nuevo más tarde');
    //     }
    // }

    // public function historial()
    // {
    //     $cambios = BitacoraLotes::paginate(10);
    //     return view('agricola.lotes.historial',['cambios' => $cambios]);
    // }
}
