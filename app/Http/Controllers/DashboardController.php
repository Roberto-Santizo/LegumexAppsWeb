<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Session;
use App\Models\EmpleadoFinca;
use App\Models\PlanSemanalFinca;
use App\Models\TareasLote;
use App\Models\UsuarioTareaLote;

class DashboardController extends Controller
{
    public function index()
    {
        $sessions = Session::limit(10)->get();

        $sessions->map(function($session){
            $last_activity = $session->last_activity;
            $last_activityDate = Carbon::createFromTimestamp($last_activity);

            $session->ultima_coneccion = $last_activityDate->format('d-m-Y');
        });

        return view('dashboards.index',['sessions' => $sessions]);
    }

    public function mantenimiento()
    {
        
        return view('dashboards.mantenimiento');
    }

    public function agricola()
    {
        $planes = PlanSemanalFinca::where('semana',Carbon::now()->weekOfYear())->get();
        $planes->map(function($plan){
            $plan->tareasRealizadas = $plan->tareasTotales->filter(function($tarea){
                if($tarea->cierre){
                    return $tarea;
                }
            });

        });
        $semana_actual = Carbon::now()->weekOfYear();

        $usuarios = EmpleadoFinca::where('department_id', 8)->WhereNotIn('position_id', [15, 9])->get();

        $usuarios->map(function($usuario) use ($semana_actual){
            $asignaciones = UsuarioTareaLote::whereRaw('WEEKOFYEAR(created_at) = ?',$semana_actual)->where('usuario_id', $usuario->id)->get();
            $usuario->horas_totales = $asignaciones->sum(function($asignacion){
                return round($asignacion->tarea_lote->horas / ($asignacion->tarea_lote->users->count()),2);
            });
            foreach ($asignaciones as $asignacion) {
                if(!$asignacion->tarea_lote->cierre)
                {
                    $usuario->activo = true;
                }
            }
            
        });
        $usuarios = $usuarios->sortBy('horas_totales');

        $tareas = TareasLote::all();

        $tareas = $tareas->filter(function($tarea){
            if($tarea->asignacion && !$tarea->cierre){
                return $tarea;
            }
        });

        return view('dashboards.agricola',['planes' => $planes,'usuarios' => $usuarios, 'semana_actual' => $semana_actual, 'tareas' => $tareas]);
    }
}
