<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class APIRendimientoTareasController extends Controller
{
    public function rendimiento($tarea_id,$finca_id,$year)
{
    try {
        $tarea = Tarea::findOrFail($tarea_id);

        $asignaciones = $tarea->asignacionesHistorico
            ->filter(fn($asignacion) => $asignacion->cierre && $asignacion->plansemanal->finca->id === intval($finca_id) && $asignacion->created_at->year === intval($year))
            ->map(function ($asignacion) {
                $tareaCreacion = $asignacion->asignacion->created_at;
                $tareaCierre = $asignacion->cierre->created_at;
                $rendimiento_real = $tareaCreacion->diffInHours($tareaCierre);
                
                return [
                    'label' => $asignacion->plansemanal->finca->finca,
                    'mes' => $tareaCierre->format('M'),
                    'horas' => round($rendimiento_real * $asignacion->users->count(), 4),
                ];
            });

        $rendimientoFinca = $asignaciones->groupBy('label')->map(function($asignaciones) {
            $horasPorMes = $asignaciones->groupBy('mes')->map(function($asignacionesMensuales) {
                return $asignacionesMensuales->avg('horas');
            })->values();

            return [
                'label' => $asignaciones->first()['label'],
                'datasets' => $horasPorMes,
            ];
        })->values();

        $data = [
            'data' => $rendimientoFinca,
            'status' => 200,
        ];

    } catch (\Throwable $th) {
        $data = [
            'mensaje' => 'No existe la tarea',
            'status' => 404,
        ];

        return response()->json($data, 404);
    }

    return response()->json($data, 200);
}

    
}
