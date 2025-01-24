<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LoteHistoricoTareasExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnFormatting, WithMultipleSheets
{

    protected $tareas;
    protected $lote;

    // Constructor para recibir el ID
    public function __construct($lote)
    {
        $this->lote = $lote;
        $this->tareas = $lote->tareas;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $rows = collect();
        Carbon::setLocale('es');

        foreach ($this->tareas as $tarea) {
            $horas_diferencia = 0;
            if ($tarea->cierre) {
                if (!$tarea->cierresParciales->isEmpty()) {
                    foreach ($tarea->cierresParciales as $cierreParcial) {
                        $horas_diferencia += $cierreParcial->fecha_inicio->diffInHours($cierreParcial->fecha_final);
                        $rendimiento = $tarea->horas / ($tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at) - $horas_diferencia) * 100;
                    }
                }
                $rows->push([
                    'LOTE' => $this->lote->nombre,
                    'TAREA' => $tarea->tarea->tarea,
                    'AÑO' =>  $tarea->plansemanal->year,
                    'SEMANA' => $tarea->plansemanal->semana,
                    'HORAS TEORICAS' => $tarea->horas,
                    'HORAS REALES' => ($tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at) - $horas_diferencia),
                    'FECHA INICIO' => $tarea->asignacion->created_at,
                    'FECHA FINAL' => $tarea->cierre->created_at,
                    'RENDIMIENTO' => $rendimiento ?? ($tarea->horas / $tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at)) * 100
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['LOTE', 'TAREA','AÑO','SEMANA','HORAS TEORICAS','HORAS REALES', 'FECHA DE INICIO', 'FECHA FINAL', 'RENDIMIENTO'];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:I1')->applyFromArray([
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

    public function sheets(): array
    {
        return [
            new LoteHistoricoTareasExport($this->lote),
            new LoteHistoricoCosechaExport($this->lote)
        ];
    }

    public function title(): string
    {
        return 'Historico Lote';
    }

    public function columnFormats(): array
    {
        return [
            'H' => '0.00%',
        ];
    }
}
