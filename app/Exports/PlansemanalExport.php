<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PlansemanalExport implements FromCollection, WithHeadings, WithMultipleSheets, WithTitle, WithStyles, WithColumnFormatting
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
                if($tarea->cierre != null){
                    $tareaCreacion = $tarea->asignacion->created_at; 
                    $tareaCierre = $tarea->cierre->created_at;
                    $rendimiento_real = $tareaCreacion->diffInHours($tareaCierre);
                }
                
                $rows->push([
                    'FINCA' => $this->plansemanal->finca->finca,
                    'SEMANA CALENDARIO' => $this->plansemanal->semana,
                    'LOTE' => $tarea->lote->nombre,
                    'CODIGO TAREA' => $tarea->tarea->code,
                    'TAREA' => $tarea->tarea->tarea,
                    'EXTRAORDINARIA' => ($tarea->extraordinaria) ?  'EXTRAORDINARIA' : 'PLANIFICADA',
                    'ESTADO' => ($tarea->cierre != null) ? 'CERRADA' : 'ABIERTA',
                    'FECHA DE INICIO' => ($tarea->asignacion) ? $tarea->asignacion->created_at->format('d-m-Y h:i:s') : 'SIN ASIGNACION',
                    'FECHA DE CIERRE' => ($tarea->cierre != null) ? $tarea->cierre->created_at->format('d-m-Y h:i:s') : 'SIN CIERRE',
                    'HORA RENDIMIENTO TEORICO' => $tarea->horas,
                    'HORA RENDIMIENTO REAL' => ($tarea->cierre != null) ?  round($rendimiento_real * $tarea->users->count(),4) : '0',
                    'RENDIMIENTO' => ($tarea->cierre != null) ? ($tarea->horas/round($rendimiento_real*$tarea->users->count(),4)) : '0',
                    'ATRASADA' => ($tarea->movimientos->count() > 0) ? 'ATRASADA' : 'PLANIFICADA',
                    'SEMANA ORIGEN' => ($tarea->movimientos->count() > 0) ? $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->semana : 'PLANIFICADA',
                ]);
           
        }

        foreach($this->plansemanal->tareasCosechaTotales as $tareaCosecha)
        {
              
            foreach ($tareaCosecha->asignaciones as $asignacion) {
                    if($asignacion->cierre){
                        $EmpleadosAsignados = $tareaCosecha->users()->whereDate('created_at',$asignacion->created_at)->count();
                        $rendimiento = $tareaCosecha->tarea->cultivo->rendimiento;
                        $rendimiento_teorico = ($EmpleadosAsignados)*8;
                        $rendimiento_real = (($asignacion->cierre->libras_total_planta) * 8)/$rendimiento;

                        $rows->push([
                            'FINCA' => $this->plansemanal->semana,
                            'SEMANA CALENDARIO' => $this->plansemanal->finca->finca,
                            'LOTE' => $tareaCosecha->lote->nombre,
                            'CODIGO TAREA' => $tareaCosecha->tarea->code,
                            'TAREA' => $tareaCosecha->tarea->tarea,
                            'EXTRAORDINARIA' => ($tarea->extraordinaria) ?  'EXTRAORDINARIA' : 'PLANIFICADA',
                            'ESTADO' => ($asignacion->cierre != null) ? 'CERRADA' : 'ABIERTA',
                            'FECHA DE INICIO' => ($asignacion->created_at) ? $asignacion->created_at->format('d-m-Y h:i:s') : 'SIN ASIGNACION',
                            'FECHA DE CIERRE' => ($asignacion->cierre != null) ? $asignacion->cierre->created_at->format('d-m-Y h:i:s') : 'SIN CIERRE',
                            'HORA RENDIMIENTO TEORICO' => $rendimiento_teorico,
                            'HORA RENDIMIENTO REAL' => $rendimiento_real,
                            'RENDIMIENTO' => ($asignacion->cierre != null) ? ($rendimiento_real/($rendimiento_teorico)) : '0',
                            'ATRASADA' => '',
                            'SEMANA ORIGEN' => '',
                        ]);
                    }
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['FINCA','SEMANA CALENDARIO','LOTE','CODIGO TAREA', 'TAREA','PLAN', 'ESTADO','FECHA DE INICIO','FECHA DE CIERRE','HORAS RENDIMIENTO TEORICO','HORAS RENDIMIENTO REAL', 'RENDIMIENTO','ATRASADA','SEMANA ORIGEN'];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:N1')->applyFromArray([
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
            new PlansemanalExport($this->plansemanal), 
            new UsuarioTareaDetalleExport($this->plansemanal) 
        ];
    }
    public function title(): string
    {
        return 'General Tareas Finca'; 
    }

      public function columnFormats(): array
    {
        return [
            'L' => '0.00%',
        ];
    }


}
