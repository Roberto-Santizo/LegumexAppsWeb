<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmpleadoIngresado;

class UsuariosFincaController extends Controller
{
   
    public function index(Request $request)
    {
        if($request->has('punch_time')){
            $ingresos = EmpleadoIngresado::whereDate('punch_time',$request->input('punch_time'))->paginate(10)->appends($request->all());
        }else{
            $ingresos = EmpleadoIngresado::whereDate('punch_time',Carbon::today())->paginate(10);
        }

        return view('agricola.UsuariosFincas.index',['ingresos' => $ingresos]);
    }

}
