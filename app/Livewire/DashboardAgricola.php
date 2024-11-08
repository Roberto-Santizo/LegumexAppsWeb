<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TareasLote;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\TareaLoteCosecha;
use App\Models\UsuarioTareaCosecha;
use App\Models\UsuarioTareaLote;

class DashboardAgricola extends Component
{

    public $planes;
    public $planesSelect;
    public $semana_actual;
    public $usuarios;
    public $tareasEnProceso;
    public $cosechasEnProceso;
    public $cosechasTerminadas;
    public $tareasRealizadas;
    public $tareasRealizadasEnSemana;
    public $tareas;
    public $tareasCosecha;
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
        $this->planes = PlanSemanalFinca::where('semana', $semana)->get();
        $this->planes->map(function ($plan) {
            $plan->tareasRealizadas = $plan->tareasTotales->filter(function ($tarea) {
                if ($tarea->cierre) {
                    return $tarea;
                }
            });
        });

        $this->usuarios = EmpleadoFinca::where('department_id', 8)->WhereNotIn('position_id', [15, 9])->get();

        $this->usuarios->map(function ($usuario) use ($semana) {
            $horas_totales_cosecha = 0;
            $asignaciones = UsuarioTareaLote::whereRaw('WEEKOFYEAR(created_at) = ?', $semana)->where('usuario_id', $usuario->id)->get();
            $asignacionesCosecha = UsuarioTareaCosecha::whereRaw('WEEKOFYEAR(created_at) = ?', $semana)->where('usuario_id', $usuario->id)->get();
            $asignacionesCosechaHoy = UsuarioTareaCosecha::whereDate('created_at', Carbon::today())->where('usuario_id', $usuario->id)->get();
            $horas_totales_tareas = $asignaciones->sum(function ($asignacion) {
                return round($asignacion->tarea_lote->horas / ($asignacion->tarea_lote->users->count()), 2);
            });

            if (!$asignacionesCosecha->isEmpty()) {
                foreach ($asignacionesCosecha as $asignacionCosecha) {
                    $cierre = $asignacionCosecha->tarealote->cierreDiario($asignacionCosecha->created_at)->get()->first();
                    if($cierre){
                        $libras_planta = $cierre->libras_total_planta;
                        $libras_finca = $cierre->libras_total_finca;
                        if($libras_planta){
                            $plantas_cosechadas = $asignacionCosecha->tarealote->cierreDiario($asignacionCosecha->created_at)->get()->first()->plantas_cosechadas;
                            $peso_cabeza = $libras_planta/$plantas_cosechadas;
                            $porcentaje = ($asignacionCosecha->libras_asignacion/$libras_finca);
                            $cabezas_cosechadas = ($porcentaje*$libras_planta)/$peso_cabeza;
                            $horas_totales_cosecha = $cabezas_cosechadas/120;
                        }
                    }

                }
            }

            $usuario->horas_totales = round($horas_totales_tareas + $horas_totales_cosecha, 2);
            foreach ($asignaciones as $asignacion) {
                if (!$asignacion->tarea_lote->cierre) {
                    $usuario->activo = true;
                }
            }

            foreach ($asignacionesCosechaHoy as $asignacion) {
                if (!$asignacion->tarealote->cierreDiario) {
                    $usuario->activo = true;
                };
            }

        });

        $this->usuarios = $this->usuarios->sortBy('horas_totales');

        $this->tareas = TareasLote::all();
        $this->tareasCosecha = TareaLoteCosecha::with('asignaciones')->get();
        $this->tareasCosecha = $this->tareasCosecha->filter(function($tarea) use ($semana) {
            return $tarea->plansemanal->semana == $semana;
        });
        
        $this->tareasEnProceso = $this->tareas->filter(function ($tarea) {
            if ($tarea->plansemanal->semana == $this->semana_actual && $tarea->asignacion && !$tarea->cierre) {
                return $tarea;
            }
        });

        $this->tareasRealizadas = $this->tareas->filter(function ($tarea) {
            return $tarea->cierre;
        });

        $this->tareasRealizadasEnSemana = $this->tareasRealizadas->filter(function ($tarea) use ($semana) {
            if ($tarea->cierre && $tarea->cierre->created_at->weekOfYear == $semana) {
                return $tarea;
            }
        });
    }

    public function buscarDatos()
    {

        if ($this->semanaNueva == null) {
            $this->semana_actual = Carbon::today()->weekOfYear;
        } else {
            $this->semana_actual = $this->semanaNueva;
        }

        $this->mostrarDatos();
    }

    public function render()
    {
        return view('livewire.dashboard-agricola');
    }
}
