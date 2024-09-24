<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\EmpleadoFinca;
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

    // Constructor para recibir el ID
    public function __construct(PlanSemanalFinca $planSemanalFinca)
    {
        $this->plansemanal = $planSemanalFinca;
    }

    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {
        $rows = collect();
        Carbon::setLocale('es');

        foreach($this->plansemanal->tareasTotales as $tarea){
                $carbonFecha = null;
                if ($tarea->asignacion) {
                    // Formatear la fecha directamente si existe el cierre
                    $carbonFecha = $tarea->asignacion->created_at->locale('es')->isoFormat('dddd');
                }

                if (!($tarea->users)->isEmpty()) {
                    foreach ($tarea->users as $asignacion) {
                        $empleado = EmpleadoFinca::where('id', $asignacion->usuario_id)->get()->first();
                        $entrada = EmpleadoIngresado::where('emp_id', $asignacion->usuario_id)->whereDate('punch_time', $asignacion->created_at)->orderBy('punch_time', 'asc')->first();
                        $salida = EmpleadoIngresado::where('emp_id', $asignacion->usuario_id)->whereDate('punch_time', $asignacion->created_at)->orderBy('punch_time', 'desc')->first();
                    
                        $rows->push([
                            'CODIGO' => $empleado->last_name,
                            'EMPLEADO' => $empleado->first_name,
                            'LOTE' => $tarea->lote->nombre,
                            'TAREA REALIZADA' => $tarea->tarea->tarea,
                            'MONTO' => ($asignacion->tarea_lote->cierre) ? (($asignacion->tarea_lote->presupuesto) / $tarea->users->count()) : '0',
                            'HORAS TOTALES' => ($asignacion->tarea_lote->cierre) ? ($asignacion->tarea_lote->horas / ($tarea->users->count())) : '0',
                            'ENTRADA' => $entrada ? $entrada->punch_time->format('d-m-Y h:m:s') : 'no existe',
                            'SALIDA' =>  $salida ? $salida->punch_time->format('d-m-Y h:m:s') : 'no existe',
                            'DIA' => ($tarea->cierre) ?  $carbonFecha : ''
                        ]);
                    }
                }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['CODIGO','EMPLEADO', 'LOTE', 'TAREA', 'MONTO GANADO', 'HORAS TOTALES', 'ENTRADA BIOMETRICO', 'SALIDA BIOMETRICO', 'DIA']; // Cambia los encabezados según lo que exportes
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'], // Color blanco para el texto
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '5564eb'], // Color verde para el fondo
            ],
        ]);
    }


    public function title(): string
    {
        return 'Detalle Tareas'; // Nombre de la hoja
    }
}
