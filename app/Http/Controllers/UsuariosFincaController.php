<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmpleadoIngresado;

class UsuariosFincaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->has('punch_time')){
            $ingresos = EmpleadoIngresado::whereDate('punch_time',$request->input('punch_time'))->paginate(10)->appends($request->all());
        }else{
            $ingresos = EmpleadoIngresado::whereDate('punch_time',Carbon::today())->paginate(10);
        }

        return view('agricola.UsuariosFincas.index',['ingresos' => $ingresos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
