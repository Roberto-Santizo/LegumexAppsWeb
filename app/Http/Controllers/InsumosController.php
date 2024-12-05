<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;
use App\Imports\InsumosImport;
use App\Exceptions\ImportExeption;
use Maatwebsite\Excel\Facades\Excel;

class InsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('agricola.insumos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agricola.insumos.create');
    }

    /**
     * Display the specified resource.
     */
    public function carga()
    {
        return view('agricola.insumos.carga');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        try {
            Excel::import(new InsumosImport, $request->file('file'));
        } catch (ImportExeption $th) {
            return back()->with('error', $th->getMessage());
        }

        return redirect()->route('insumos')->with('success', 'Carga de insumo realizada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insumo $insumo)
    {
        return view('agricola.insumos.edit',compact(['insumo']));
    }
}
