<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\EmpleadoIngresado;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuarioTareaDetalleExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $plansemanal;

    public function __construct(PlanSemanalFinca $planSemanalFinca)
    {
        $this->plansemanal = $planSemanalFinca;
    }

    public function collection()
    {
        Carbon::setLocale('es');
        $rows = collect();

        $this->plansemanal->tareasTotales->each(function ($tarea) use ($rows) {
            $this->procesarTarea($tarea, $rows);
        });

        $this->plansemanal->tareasCosechaTotales->each(function ($tareaLoteCosecha) use ($rows) {
            if($tareaLoteCosecha->asignacionDiaria->cierre)
            {
                $this->procesarTareaCosecha($tareaLoteCosecha, $rows);
            }
        });

        return $rows;
    }

    protected function procesarTarea($tarea, &$rows)
    {
        if ($tarea->users->isEmpty()) return;

        $carbonFecha = $tarea->asignacion ? $tarea->asignacion->created_at->isoFormat('dddd') : '';

        foreach ($tarea->users as $asignacion) {
            $entrada = $this->obtenerPunch('asc', $asignacion);
            $salida = $this->obtenerPunch('desc', $asignacion);

            $rows->push([
                'CODIGO' => $asignacion->codigo,
                'EMPLEADO' => $asignacion->nombre,
                'LOTE' => $tarea->lote->nombre,
                'TAREA REALIZADA' => $tarea->tarea->tarea,
                'PLAN' => $tarea->extraordinaria ? 'EXTRAORDINARIA' : 'PLANIFICADA',
                'MONTO' => $asignacion->tarea_lote->cierre ? ($asignacion->tarea_lote->presupuesto / $tarea->users->count()) : '0',
                'HORAS TOTALES' => $asignacion->tarea_lote->cierre ? ($asignacion->tarea_lote->horas / $tarea->users->count()) : '0',
                'ENTRADA' => $entrada,
                'SALIDA' => $salida,
                'DIA' => $carbonFecha
            ]);
        }
    }

    protected function procesarTareaCosecha($tareaLoteCosecha, &$rows)
    {
        if ($tareaLoteCosecha->users->isEmpty()) return;

        $usuarios = $tareaLoteCosecha->users()->orderBy('codigo', 'DESC')->get();
        $asignaciones = $tareaLoteCosecha->asignaciones->map(function ($asignacion) {
            return $this->transformarAsignacion($asignacion);
        });

        $usuarios->each(function ($asignacionUsuario) use ($asignaciones, $rows, $tareaLoteCosecha) {
            $this->procesarUsuarioCosecha($asignacionUsuario, $asignaciones, $tareaLoteCosecha, $rows);
        });
    }

    protected function transformarAsignacion($asignacion)
    {
        $asignacion->fechaCosecha = $asignacion->created_at->isoFormat('dddd D [de] MMMM [de] YYYY');
        $asignacion->fechaInicio = $asignacion->created_at->format('d-m-Y h:i:s A');
        $asignacion->fechaFinal = $asignacion->cierre->created_at->format('d-m-Y h:i:s A');
        $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal), 3);
        $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
        $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;

        return $asignacion;
    }

    protected function procesarUsuarioCosecha($asignacionUsuario, $asignaciones, $tareaLoteCosecha, &$rows)
    {
       
        $asignacion = $asignaciones->filter(function ($asignacionDiaria) use ($asignacionUsuario) {
            if($asignacionDiaria->created_at->toDateString() === $asignacionUsuario->created_at->toDateString())
            {
                $asignacionDiaria->totalPersonas = $asignacionDiaria->tareaLoteCosecha->users()->whereDate('created_at',$asignacionDiaria->created_at)->count();
                    $pesoLbCabeza = round(($asignacionDiaria->totalCosechadoPlanta / $asignacionDiaria->cierre->plantas_cosechadas),2);
                    $rendimientoTeoricoPorPersona =  round(($pesoLbCabeza * $asignacionDiaria->tareaLoteCosecha->tarea->cultivo->rendimiento),2);

                    $asignacionDiaria->montoTotal = round(((($asignacionDiaria->totalCosechadoPlanta/ $rendimientoTeoricoPorPersona) * 8)*11.98),2);
                    return $asignacionDiaria;
            }
            return ;
        })->first();
        
        $carbonFecha = $asignacion ? $asignacion->created_at->isoFormat('dddd') : '';
        $porcentaje = $asignacionUsuario->libras_asignacion / $asignacion->totalCosechadoFinca;
        $librasAsignacionPlanta = round($porcentaje * $asignacion->totalCosechadoPlanta, 4);
        $horasTotales = ($librasAsignacionPlanta * 8) / $tareaLoteCosecha->tarea->cultivo->rendimiento;

        $entrada = $this->obtenerPunch('asc', $asignacionUsuario);
        $salida = $this->obtenerPunch('desc', $asignacionUsuario);

        $rows->push([
            'CODIGO' => $asignacionUsuario->codigo,
            'EMPLEADO' => $asignacionUsuario->nombre,
            'LOTE' => $tareaLoteCosecha->lote->nombre,
            'TAREA REALIZADA' => $tareaLoteCosecha->tarea->tarea,
            'PLAN' => 'PLANIFICADA',
            'MONTO' => round($porcentaje * $asignacion->montoTotal, 4),
            'HORAS TOTALES' => $horasTotales,
            'ENTRADA' => $entrada,
            'SALIDA' => $salida,
            'DIA' => $carbonFecha
        ]);
    }

    protected function obtenerPunch($orden, $asignacion)
    {
        $punch = EmpleadoIngresado::where('emp_id', $asignacion->usuario_id)
            ->whereDate('punch_time', $asignacion->created_at)
            ->orderBy('punch_time', $orden)
            ->first();

        return $punch ? $punch->punch_time->format('d-m-Y h:i:s') : 'no existe';
    }

    public function headings(): array
    {
        return ['CODIGO', 'EMPLEADO', 'LOTE', 'TAREA REALIZADA', 'PLAN', 'MONTO GANADO', 'HORAS TOTALES', 'ENTRADA BIOMETRICO', 'SALIDA BIOMETRICO', 'DIA'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => '5564eb']],
        ]);
    }

    public function title(): string
    {
        return 'Detalle Tareas';
    }
}
