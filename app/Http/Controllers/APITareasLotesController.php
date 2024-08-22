<?php

namespace App\Http\Controllers;

use App\Models\UsuarioTareaLote;
use Illuminate\Http\Request;

class APITareasLotesController extends Controller
{
    public function store(Request $request)
    {
        try {
            UsuarioTareaLote::create([
                'usuario_id' => $request->usuario_id,
                'tarealote_id' => $request->tarealote_id
            ]);

             $data = [ 
                    'message' => 'Usuario Agregado Correctamente',
                    'status' => 200
                ];
            
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [ 
                'message' => 'Error al agregar el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

    }

}
