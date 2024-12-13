<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmpleadoFinca;
use App\Models\Finca;
use App\Models\PlanSemanalFinca;
use Illuminate\Support\Carbon;
use App\Models\UsuarioTareaLote;
use App\Models\UsuarioTareaCosecha;

class DashboardRecursos extends Component
{

    public $isOpen = false;
    public $semana_actual = 50;
    public $usuarios;
    public $semana;
    public $planes;
    public $semanaNueva;
    public $finca = 0;

    public function mount()
    {
        $this->usuarios = EmpleadoFinca::whereNotIn('position_id', [15, 9])->get();
        $this->planes = PlanSemanalFinca::where('semana', $this->semana_actual)->get();
        $this->mostrarDatos();
    }

    public function mostrarDatos()
    {
        $semana = $this->semana_actual;
        $this->usuarios->map(function ($usuario) use ($semana) {
            $horas_totales_cosecha = 0;
            $asignaciones = UsuarioTareaLote::whereRaw('WEEKOFYEAR(created_at) = ?', [$semana])
                ->where('usuario_id', $usuario->id)
                ->get();

            $asignacionesCosecha = UsuarioTareaCosecha::whereRaw('WEEKOFYEAR(created_at) = ?', [$semana])
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

            $usuario->finca = Finca::find($usuario->department_id)->finca;
            $usuario->horas_totales = round($horas_totales_tareas + $horas_totales_cosecha, 2);

        });

        $this->usuarios = $this->usuarios->sortBy('horas_totales');
    }

    public function borrarFiltros()
    {
        $this->semanaNueva = null;
        $this->finca = 0;
        $this->mostrarDatos();
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
        } else {
            $this->planes = PlanSemanalFinca::where('semana', $this->semana_actual)->get();
            $this->usuarios = EmpleadoFinca::whereNotIn('position_id', [15, 9])->get();
        }

        $this->mostrarDatos();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = !$this->isOpen;
        $this->mostrarDatos();
    }

    public function render()
    {
        return view('livewire.dashboard-recursos');
    }
}
