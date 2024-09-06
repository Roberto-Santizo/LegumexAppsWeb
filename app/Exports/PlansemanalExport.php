<?php

namespace App\Exports;

use App\Models\PlanSemanalFinca;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlansemanalExport implements FromCollection, WithHeadings, WithMultipleSheets, WithTitle, WithStyles 
{
   

    protected $id;

    // Constructor para recibir el ID
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
        * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $plansemanal = PlanSemanalFinca::findOrFail($this->id);
        
        $rows = collect();
        
        foreach($plansemanal->finca->lotes as $lote){
            foreach ($lote->tareas as $tarea) {
                $rows->push([
                    'FINCA' => $plansemanal->semana,
                    'SEMANA CALENDARIO' => $plansemanal->finca->finca,
                    'LOTE' => $lote->nombre,
                    'TAREA' => $tarea->tarea->tarea,
                    'ESTADO' => ($tarea->cierre) ? 'CERRADO' : 'ABIERTO',
                    'FECHA DE INICIO' => ($tarea->asignacion) ? $tarea->asignacion->created_at->format('d-m-Y h:m') : 'SIN ASIGNACION',
                    'FECHA DE CIERRE' => ($tarea->cierre) ? $tarea->cierre->created_at : 'SIN CIERRE',
                    'TOTAL DE HORAS REALES DE LA TAREA' => ($tarea->cierre) ? (round(($tarea->asignacion->created_at)->diffInHours($tarea->cierre->created_at),2)) : '0',

                ]);
            }
           
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['FINCA','SEMANA CALENDARIO','LOTE', 'TAREA', 'ESTADO','FECHA DE INICIO','FECHA DE CIERRE','HORAS RENDIMIENTO'];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'], // Color blanco para el texto
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '5564eb'], // Color verde para el fondo
            ],
        ]);

        // Si quieres aplicar estilos adicionales a otras celdas, puedes hacerlo aquí.
    }
    
    public function sheets(): array
    {
        return [
            new PlansemanalExport($this->id), // Primera hoja
            new UsuarioTareaDetalleExport($this->id) // Segunda hoja
        ];
    }
    public function title(): string
    {
        return 'General Tareas Finca'; // Nombre de la hoja
    }

}
