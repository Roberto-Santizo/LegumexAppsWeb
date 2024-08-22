<?php

namespace App\Http\Controllers;

use App\Models\TareasLote;
use App\Models\UsuarioTareaLote;
use Illuminate\Http\Request;

class APITareasLotesController extends Controller
{
    public function store(Request $request)
    {
        try {

            $tarea = TareasLote::find($request->tarealote_id);

            if($tarea->cupos > 0){
                UsuarioTareaLote::create([
                    'usuario_id' => $request->usuario_id,
                    'tarealote_id' => $request->tarealote_id
                ]);

                $tarea->cupos -=1;
                $tarea->save();

                $data = [
                    'message' => 'Usuario Agregado Correctamente',
                    'status' => 200
                ];
    
                return response()->json($data, 200);
            }else{
                $data = [
                    'message' => 'No hay cupos disponibles',
                    'status' => 200
                ];

                return response()->json($data, 200);
            }
           
        } catch (\Throwable $th) {
            $data = [
                'message' => 'Error al agregar el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $tarea = TareasLote::find($request->tarealote_id);

            // Intenta eliminar el registro
            $deletedCount = UsuarioTareaLote::where('usuario_id', $request->usuario_id)
                            ->where('tarealote_id', $request->tarealote_id)
                            ->delete();
        
            if ($deletedCount > 0) {
                $tarea->cupos++;
                $tarea->save();
                $data = [
                    'message' => 'Usuario Desasignado Correctamente',
                    'status' => 200
                ];
                return response()->json($data, 200);
            } else {
                // Esto no debería suceder si siempre hay un registro, pero se maneja por seguridad
                $data = [
                    'message' => 'No se encontró la asignación del usuario a la tarea',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }
        } catch (\Throwable $th) {
            // Manejo de excepciones
            $data = [
                'message' => 'Error del servidor, intentelo de nuevo más tarde',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        
    }
}
