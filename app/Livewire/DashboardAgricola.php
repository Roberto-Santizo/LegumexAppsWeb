<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TareasLote;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\TareaLoteCosecha;
use App\Models\UsuarioTareaLote;
use App\Models\UsuarioTareaCosecha;

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
    public $isOpen = false;
    public $finca = 0;
    public $horasDron = 0;
    public $userRole = '';

    public function mount()
    {
        $this->userRole = auth()->user()->getRoleNames()->first();

        if ($this->userRole == 'auxfinca') {
            $this->finca = $this->getFincaId();
        }

        $this->buscarDatos();
        $this->mostrarDatos();
    }

    private function getFincaId()
    {
        $PermisoFinca = [
            'tehuya' => 4,
            'alameda' => 8,
            'linda' => 5
        ];
        $user = auth()->user();
        $finca = $user->getAllPermissions()->first()->name;

        return $PermisoFinca[$finca];
    }

    public function buscarDatos()
    {
        $this->semana_actual = $this->semanaNueva ?? Carbon::today()->weekOfYear;

        if ($this->finca != 0) {
            $this->planes = PlanSemanalFinca::where('semana', $this->semana_actual)
                ->where('finca_id', $this->finca)
                ->get();

            $this->usuarios = EmpleadoFinca::where('department_id', $this->finca)
                ->whereNotIn('position_id', [15, 9])
                ->get();

            $this->tareas = TareasLote::whereHas('plansemanal', function ($query) {
                $query->where('finca_id', $this->finca);
            })->get();

            $this->tareasCosecha = TareaLoteCosecha::whereHas('plansemanal', function ($query) {
                $query->where('finca_id', $this->finca);
            })->with('asignaciones')->get();
        } else {
            $this->tareasCosecha = TareaLoteCosecha::with('asignaciones')->get();
            $this->planes = PlanSemanalFinca::where('semana', $this->semana_actual)->get();
            $this->usuarios = EmpleadoFinca::whereNotIn('position_id', [15, 9])->get();
            $this->tareas = TareasLote::whereHas('plansemanal',function ($query){
                $query->where('semana',$this->semana_actual);
            })->get();
        }

        $this->mostrarDatos();
        $this->closeModal();
    }

    public function mostrarDatos()
    {
        $semana = $this->semana_actual;
        $this->horasDron = 0;
        $this->tareas->map(function ($tarea) {
            if ($tarea->asignacion && $tarea->asignacion->use_dron && $tarea->cierre) {
                $this->horasDron += round($tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at), 2);
            }
        });

        $this->planes->map(function ($plan) {
            $plan->tareasRealizadas = $plan->tareasTotales->filter(function ($tarea) {
                return $tarea->cierre;
            });
        });


        $this->usuarios->map(function ($usuario) use ($semana) {
            $horas_totales_cosecha = 0;
            $asignaciones = UsuarioTareaLote::whereRaw('WEEKOFYEAR(created_at) = ?', [$semana])
                ->where('usuario_id', $usuario->id)
                ->get();

            $asignacionesCosecha = UsuarioTareaCosecha::whereRaw('WEEKOFYEAR(created_at) = ?', [$semana])
                ->where('usuario_id', $usuario->id)
                ->get();

            $asignacionesCosechaHoy = UsuarioTareaCosecha::whereDate('created_at', Carbon::today())
                ->where('usuario_id', $usuario->id)
                ->get();

            $horas_totales_tareas = $asignaciones->sum(function ($asignacion) {
                return round($asignacion->tarea_lote->horas / $asignacion->tarea_lote->users->count(), 2);
            });

            foreach ($asignacionesCosecha as $asignacionCosecha) {
                $cierre = $asignacionCosecha->tarealote
                    ->cierreDiario($asignacionCosecha->created_at)
                    ->get()
                    ->first();
                if ($cierre) {
                    $libras_planta = $cierre->libras_total_planta;
                    $libras_finca = $cierre->libras_total_finca;
                    if ($libras_planta) {
                        $plantas_cosechadas = $cierre->plantas_cosechadas;
                        $peso_cabeza = $libras_planta / $plantas_cosechadas;
                        $porcentaje = $asignacionCosecha->libras_asignacion / $libras_finca;
                        $cabezas_cosechadas = ($porcentaje * $libras_planta) / $peso_cabeza;
                        $horas_totales_cosecha += $cabezas_cosechadas / 120;
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
                }
            }
        });

        $this->usuarios = $this->usuarios->sortBy('horas_totales');
        $this->tareasCosecha = $this->tareasCosecha->filter(function ($tarea) use ($semana) {
            return $tarea->plansemanal->semana == $semana;
        });

        $this->tareasEnProceso = $this->tareas->filter(function ($tarea) {
            return $tarea->plansemanal->semana == $this->semana_actual &&
                $tarea->asignacion &&
                !$tarea->cierre;
        });

        $this->tareasRealizadas = $this->tareas->filter(function ($tarea) {
            return $tarea->cierre;
        });

        $this->tareasRealizadasEnSemana = $this->tareasRealizadas->filter(function ($tarea) use ($semana) {
            return $tarea->cierre && $tarea->cierre->created_at->weekOfYear == $semana;
        });
    }


    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function borrarFiltros()
    {
        $this->semanaNueva = null;
        $this->finca = 0;
        $this->mostrarDatos();
        $this->closeModal();
    }

    public function render()
    {
        $this->mostrarDatos();
        return view('livewire.dashboard-agricola');
    }
}
