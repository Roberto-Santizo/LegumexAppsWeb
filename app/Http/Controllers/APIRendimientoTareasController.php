<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class APIRendimientoTareasController extends Controller
{
    public function rendimiento($tarea_id)
    {
        try {
            $tarea = Tarea::findOrFail($tarea_id);
            $asignaciones = $tarea->asignacionesHistorico->map(function ($asignacion) {
                if($asignacion->cierre){
                    $tareaCreacion = $asignacion->asignacion->created_at; 
                    $tareaCierre = $asignacion->cierre->created_at;
                    $rendimiento_real = $tareaCreacion->diffInHours($tareaCierre);
                    $asignacion->horas = round($rendimiento_real * $asignacion->users->count(),4);
                }
                return [
                    'label'=> $asignacion->plansemanal->finca->finca,
                    'mes' => ($asignacion->cierre) ? $asignacion->cierre->created_at->format('M') : 'Sin mes',
                    'horas' => $asignacion->horas ?? 'sin horas'
                ];
            });

            // // Convertir los datos en una colección de Laravel para poder usar métodos de colección
            $elementos = collect($asignaciones);

            
            // // Agrupar por mes y calcular el promedio de horas
            $resultado = $elementos->groupBy('mes')->map(function ($grupo, $mes) {
                $totalHoras = $grupo->sum('horas'); // Sumar las horas del grupo
                $cantidadSemanas = $grupo->count(); // Contar las semanas en el grupo
                $horaPromedio = $totalHoras / $cantidadSemanas; // Calcular el promedio
                
                // Retornar el formato solicitado
                return [
                    'label' => $grupo->first()['label'], // Usar el primer label, ya que todos son iguales
                    'mes' => $mes,
                    'hora_promedio' => round($horaPromedio, 2) // Redondear a 2 decimales
                ];
            });

            // $horasPromedio = $resultado->pluck('hora_promedio')->toArray();

            // // // Formatear los datos en el formato requerido
            // $formatoFinal = [

            //     'data' => $horasPromedio, // Lista de horas promedio
            //     'borderColor' => 'rgba(255, 99, 132, 1)',  
            //     'backgroundColor' => 'rgba(255, 99, 132, 0.5)',  
            //     'yAxisID' => 'y',
            // ];
            


            $data = [ 
                'data' => $resultado,
                'status' => 200
            ];
            
        } catch (\Throwable $th) {
            $data = [
                'mensaje' => 'No existe la tarea',
                'status' => 404
            ];

            return response()->json($data, 404);
        }
        
        return response()->json($data, 200); 
    }
}
