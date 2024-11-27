<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\EmpleadoIngresado;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlanillaSemanalExport implements FromCollection, WithHeadings, WithStyles
{
    protected $plansemanal;
    protected $tareasSemanales;
    protected $tareasSemanalesCosecha;
    protected $empleados = [];
    protected $empleadosAux;

    public function __construct(PlanSemanalFinca $planSemanalFinca)
    {
        $this->plansemanal = $planSemanalFinca;
        $this->tareasSemanales = $this->plansemanal->tareasTotales;
        $this->tareasSemanalesCosecha = $this->plansemanal->tareasCosechaTotales;
        $todasTareas = $this->tareasSemanales->merge($this->tareasSemanalesCosecha);

        foreach ($todasTareas as $tarea) {
            foreach ($tarea->users as $asignacion) {
                $this->empleados[$asignacion->codigo] = [
                    'nombre' => $asignacion->nombre,
                    'codigo' => $asignacion->codigo,
                    'usuario_id' => $asignacion->usuario_id,
                    'horas_totales' => 0,
                    'monto_total' => 0,
                    'bono' => 0
                ];
            }
        }
        $this->empleados = collect($this->empleados);
        $this->empleadosAux = $this->empleados;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $rows = collect();
        Carbon::setLocale('es');

        foreach ($this->tareasSemanales as $tarea) {
            if ($tarea->cierresParciales->isEmpty() && $tarea->cierre) {
                $this->formatTareaSinCierres($tarea);
            } elseif ($tarea->cierre) {
                $this->formatTareaConCierres($tarea);
            }
        }

        foreach ($this->tareasSemanalesCosecha as $tarea) {
            $this->formatTareaCosecha($tarea);
        }

        foreach($this->empleados as $empleado){
            if($empleado['horas_totales'] > 44){
                $empleado['bono'] = 12*11.98;
            }
            $rows->push([
                'CODIGO' => $empleado['codigo'],
                'NOMBRE' => $empleado['nombre'],
                'HORAS SEMANALES' => $empleado['horas_totales'],
                'MONTO TAREAS' => $empleado['monto_total'],
                'BONO' => $empleado['bono'],
                'SEPTIMO' => 0,
                'TOTAL A DEVENGAR' => $empleado['monto_total'] + $empleado['bono']
            ]);
        }

        return $rows;
    }

    public function formatTareaSinCierres($tarea)
    {
        $this->empleados = $this->empleados->map(function ($empleado) use ($tarea) {
            if ($tarea->users->contains('usuario_id', $empleado['usuario_id'])) {
                $empleado['horas_totales'] += $tarea->horas / $tarea->users->count();
                $empleado['monto_total'] += $tarea->presupuesto / $tarea->users->count();
            }
            return $empleado;
        });
    }

    public function formatTareaConCierres($tarea)
    {
        $fechas = [];

        $primerFecha = $tarea->asignacion->created_at;
        $ultimaFecha = $tarea->cierre->created_at;
        $fechas[] = $primerFecha;
        $fechas[] = $ultimaFecha;

        $fechasInicio = $tarea->cierresParciales()->pluck('fecha_inicio')->toArray();
        $fechasFinal = $tarea->cierresParciales()->pluck('fecha_final')->toArray();

        $fechasEntrada = collect(array_merge($fechasInicio, $fechasFinal))
            ->map(fn($fecha) => date('Y-m-d', strtotime($fecha)))
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $fechas = collect(array_merge($fechasInicio, $fechasFinal, $fechas))
            ->sort()
            ->values();

        $fechasAgrupadas = $fechas->groupBy(function ($fecha) {
            return $fecha->toDateString();
        });

        $fechasAgrupadas->map(function ($fechas) {
            $horas_totales = $fechas[0]->diffInHours($fechas[1]);
            $fechas->horas_totales = $horas_totales;
        });

        $this->empleadosAux = $this->empleadosAux->map(function ($empleado) use ($fechasEntrada, $tarea, $fechasAgrupadas) {
            foreach ($fechasEntrada as $fecha) {
                if ($tarea->users->contains('usuario_id', $empleado['usuario_id'])) {
                    $entrada = EmpleadoIngresado::whereDate('punch_time', $fecha)->where('emp_id', $empleado['usuario_id'])->exists();
                    if ($entrada) {
                        $empleado['horas_totales'] += $fechasAgrupadas[$fecha]->horas_totales;
                    }
                }
            }
            return $empleado;
        });

        $this->empleados = $this->empleados->map(function ($empleado) use ($tarea) {
            if ($tarea->users->contains('usuario_id', $empleado['usuario_id'])) {
                $porcentaje = $this->empleadosAux[$empleado['codigo']]['horas_totales'] / $this->empleadosAux->sum('horas_totales');
                $empleado['horas_totales'] += $porcentaje * $tarea->horas;
                $empleado['monto_total'] += $porcentaje * $tarea->presupuesto;
            }
            return $empleado;
        });
    }

    public function formatTareaCosecha($tarea)
    {
        $asignaciones = $tarea->asignaciones->filter(function ($asignacion) {
            if ($asignacion->cierre) {
                if ($asignacion->cierre->libras_total_planta) {
                    $asignacion->totalPersonas = $asignacion->tareaLoteCosecha->users()->whereDate('created_at', $asignacion->created_at)->count();

                    $pesoLbCabeza = round(($asignacion->cierre->plantas_cosechadas / $asignacion->cierre->plantas_cosechadas), 2);
                    $rendimientoTeoricoPorPersona =  round(($pesoLbCabeza * $asignacion->tareaLoteCosecha->tarea->cultivo->rendimiento), 2);

                    $asignacion->montoTotal = round(((($asignacion->cierre->plantas_cosechadas / $rendimientoTeoricoPorPersona) * 8) * 11.98), 2);
                    $asignacion->peso_cabeza = $pesoLbCabeza;
                    return $asignacion;
                }
            }
        });

        $this->empleados = $this->empleados->map(function ($empleado) use ($asignaciones) {
            foreach ($asignaciones as $asignacion) {
                $asignacionesUsuarios = $asignacion->tareaLoteCosecha->users()->whereDate('created_at', $asignacion->created_at)->get();
                $asignacionUsuario = $asignacionesUsuarios->filter(function ($asignacionCosecha) use ($empleado) {
                    if ($asignacionCosecha->codigo === $empleado['codigo']) {
                        return $asignacionCosecha;
                    }
                });

                if (!$asignacionUsuario->isEmpty()) {
                    $porcentaje = $asignacionUsuario->first()->libras_asignacion / $asignacion->cierre->libras_total_planta;
                    $cabezas_cosechadas = ($porcentaje *  $asignacion->cierre->plantas_cosechadas) / $asignacion->peso_cabeza;
                    $horasTotales = $cabezas_cosechadas / 120;
                    $montoTotal = $porcentaje * $asignacion->montoTotal;
                    $empleado['horas_totales'] += round($horasTotales,2);
                    $empleado['monto_total'] += $montoTotal;

                }
            }

            return $empleado;
        });

    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '5564eb'],
            ],
        ]);
    }

    public function headings(): array
    {
        return ['CODIGO', 'NOMBRE', 'HORAS SEMANALES','MONTO TAREAS', 'BONO', 'SEPTIMO', 'TOTAL A DEVENGAR'];
    }
}
