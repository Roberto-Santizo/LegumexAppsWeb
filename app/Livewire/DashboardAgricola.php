<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TareasLote;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\UsuarioTareaLote;

class DashboardAgricola extends Component
{

    public $planes;
    public $planesSelect;
    public $semana_actual;
    public $usuarios;
    public $tareasEnProceso;
    public $tareasRealizadas;
    public $tareasRealizadasEnSemana;
    public $tareas;
    public $semanaNueva;

    public function mount()
    {
        $this->planesSelect = PlanSemanalFinca::all();
        $this->semana_actual = Carbon::now()->weekOfYear;
        $this->mostrarDatos();
    }

    public function mostrarDatos()
    {
        $semana = $this->semana_actual;
        $this->planes = PlanSemanalFinca::where('semana',$semana)->get();
        $this->planes->map(function($plan){
            $plan->tareasRealizadas = $plan->tareasTotales->filter(function($tarea){
                if($tarea->cierre){
                    return $tarea;
                }
            });

        });

        $this->usuarios = EmpleadoFinca::where('department_id', 8)->WhereNotIn('position_id', [15, 9])->get();

        $this->usuarios->map(function($usuario) use ($semana){
            $asignaciones = UsuarioTareaLote::whereRaw('WEEKOFYEAR(created_at) = ?',$semana)->where('usuario_id', $usuario->id)->get();
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

        $this->usuarios = $this->usuarios->sortBy('horas_totales');

        $this->tareas = TareasLote::all();

        $this->tareasEnProceso = $this->tareas->filter(function($tarea){
            if($tarea->asignacion && !$tarea->cierre){
                return $tarea;
            }
        });

        $this->tareasRealizadas = $this->tareas->filter(function($tarea){
            return $tarea->cierre;
        });

        $this->tareasRealizadasEnSemana = $this->tareasRealizadas->filter(function($tarea) use ($semana) {
            if($tarea->cierre && $tarea->cierre->created_at->weekOfYear == $semana){
                return $tarea;
            }
        });
    }

    public function buscarDatos()
    {
        $this->semana_actual = $this->semanaNueva;

        $this->mostrarDatos();
    }

    public function render()
    {
        return view('livewire.dashboard-agricola');
    }
}
