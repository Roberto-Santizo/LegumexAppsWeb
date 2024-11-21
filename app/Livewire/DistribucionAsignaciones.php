<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\EmpleadoIngresado;

class DistribucionAsignaciones extends Component
{
    public $tarea;
    public $fechasEntrada;
    public $fechas;
    public $fechasAgrupadas;

    public function mount()
    {
        $fechas = [];

        $primerFecha = $this->tarea->asignacion->created_at;
        $ultimaFecha = $this->tarea->cierre->created_at;
        $fechas[] = $primerFecha;
        $fechas[] = $ultimaFecha;

        $fechasInicio = $this->tarea->cierresParciales()->pluck('fecha_inicio')->toArray();
        $fechasFinal = $this->tarea->cierresParciales()->pluck('fecha_final')->toArray();

        $this->fechasEntrada = collect(array_merge($fechasInicio, $fechasFinal))
            ->map(fn($fecha) => date('Y-m-d', strtotime($fecha)))
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $this->fechas = collect(array_merge($fechasInicio, $fechasFinal, $fechas))
            ->sort()
            ->values();

        $this->fechasAgrupadas = $this->fechas->groupBy(function ($fecha) {
            return $fecha->toDateString(); 
        });

        $this->fechasAgrupadas->map(function($fechas) {
            $horas_totales = $fechas[0]->diffInHours($fechas[1]);
            $fechas->horas_totales = $horas_totales;
        });

        $entradas_usuarios = [];

        $this->tarea->users->map(function ($user) use (&$entradas_usuarios) {
            foreach ($this->fechasEntrada as $fecha) {
                $entrada = EmpleadoIngresado::whereDate('punch_time', $fecha)
                    ->where('emp_id', $user->usuario_id)
                    ->exists();

                if ($entrada) {
                    if (!isset($entradas_usuarios[$fecha])) {
                        $entradas_usuarios[$fecha] = 0;
                    }
                    $entradas_usuarios[$fecha]++;
                }
            }
        });

        $this->tarea->users->map(function ($user) {
            $entradas = [];
            $horasTotales = 0;
            foreach ($this->fechasEntrada as $fecha) {
                $entrada = EmpleadoIngresado::whereDate('punch_time', $fecha)->where('emp_id', $user->usuario_id)->get();
                if (!$entrada->isEmpty()) {
                    $horas = $this->fechasAgrupadas[$fecha]->horas_totales;
                    $horasTotales += $this->fechasAgrupadas[$fecha]->horas_totales;
                    $entradas[$fecha] = ['estado' => true, 'horas' => $horas];
                } else {
                    $entradas[$fecha] = ['estado' => false, 'horas' => 0];
                }
            }

            $user->horasTotales = $horasTotales;
            $user->entradas = $entradas;
            return $user;
        });

        $this->tarea->users->map(function($user){
            $horasTotalesSemana = $this->tarea->users->sum('horasTotales');
            $user->porcentaje = $user->horasTotales / $horasTotalesSemana;
            $user->horas_totales = $this->tarea->horas * $user->porcentaje;
            $user->monto_total = $this->tarea->presupuesto * $user->porcentaje;
        });
    }

    public function render()
    {
        return view('livewire.distribucion-asignaciones');
    }
}
