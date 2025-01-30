<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LoteHistoricoCosechaExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnFormatting
{

    protected $cosechas;
    protected $lote;

    // Constructor para recibir el ID
    public function __construct($lote)
    {
        $this->cosechas = $lote->tareasCosecha;
        $this->lote = $lote;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $rows = collect();
        $asignaciones = [];
        Carbon::setLocale('es');

        foreach ($this->cosechas as $cosecha) {
            if ($cosecha->asignaciones) {
                $asignaciones = $cosecha->asignaciones->filter(function ($asignacion) {
                    if ($asignacion->cierre && $asignacion->cierre->libras_total_planta) {
                        $asignacion->fechaCosecha = $asignacion->created_at->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
                        $asignacion->plantas_cosechadas = $asignacion->cierre->plantas_cosechadas;
                        $asignacion->fechaInicio = $asignacion->created_at->format('d-m-Y h:i:s A');
                        $asignacion->fechaFinal = $asignacion->cierre->created_at->format('d-m-Y h:i:s A');
                        $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal), 3);
                        $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
                        $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;

                        return $asignacion;
                    }
                });

                foreach ($asignaciones as $asignacion) {
                    $rows->push([
                        'LOTE' => $this->lote->nombre,
                        'TAREA' => 'COSECHA',
                        'FECHA COSECHA' =>  $asignacion->fechaCosecha,
                        'TOTAL COSECHADO (LBS)' => $asignacion->totalCosechadoPlanta,
                    ]);
                }
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['LOTE', 'TAREA', 'FECHA DE COSECHA', 'TOTAL COSECHADO LBS)'];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:D1')->applyFromArray([
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
        return 'Historico Lote Cosecha';
    }

    public function columnFormats(): array
    {
        return [
            'C' => '0.00%',
        ];
    }
}
