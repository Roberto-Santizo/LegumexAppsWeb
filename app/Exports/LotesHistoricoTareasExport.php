<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LotesHistoricoTareasExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $lotes;

    public function __construct($lotes)
    {
        $this->lotes = $lotes;
    }

    public function collection()
    {
        $rows = collect();
        foreach ($this->lotes as $lote) {
            foreach ($lote->tareas as $tarea) {
                $horas_diferencia = 0;
                $rendimiento = 0;
                $horas_reales = 0;
                if (!$tarea->cierresParciales->isEmpty()) {
                    foreach ($tarea->cierresParciales as $cierreParcial) {
                        $horas_diferencia += $cierreParcial->fecha_inicio->diffInHours($cierreParcial->fecha_final);
                        $rendimiento = $tarea->horas / ($tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at) - $horas_diferencia) * 100;
                    }
                }
                if($tarea->asignacion){
                    $horas_reales = ($tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at) - $horas_diferencia);
                }

                $rows->push([
                    'LOTE' => $lote->nombre,
                    'TAREA' => $tarea->tarea->tarea,
                    'AÑO' =>  $tarea->plansemanal->year,
                    'SEMANA' => $tarea->plansemanal->semana,
                    'HORAS TEORICAS' => $tarea->horas,
                    'HORAS REALES' => $horas_reales ?? '',
                    'FECHA INICIO' => $tarea->asignacion->created_at ?? 'SIN INICIO',
                    'FECHA FINAL' => $tarea->cierre->created_at ?? 'SIN CIERRE',
                    'PLAN' => $tarea->extraordinaria ? 'EXTRAORDINARIA' : 'PLANIFICADA',
                    'ATRASADA' => ($tarea->movimientos->count() > 0) ? 'ATRASADA' : 'PLANIFICADA',
                    'SEMANA ORIGEN' => ($tarea->movimientos->count() > 0) ? $tarea->movimientos()->orderBy('id', 'DESC')->first()->plan_origen->semana : 'PLANIFICADA',
                    'RENDIMIENTO' => ($tarea->cierre) ? $rendimiento : ''
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['LOTE', 'TAREA', 'AÑO', 'SEMANA', 'HORAS TEORICAS', 'HORAS REALES', 'FECHA DE INICIO', 'FECHA FINAL', 'PLAN', 'ATRASADA', 'SEMANA ORIGEN', 'RENDIMIENTO'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->applyFromArray([
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

    public function title(): string
    {
        return 'Historico Lotes';
    }

    public function columnFormats(): array
    {
        return [
            'L' => '0.00%',
        ];
    }
}
