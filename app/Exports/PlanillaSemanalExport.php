<?php

namespace App\Exports;

use App\Models\AsignacionDiariaCosecha;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\UsuarioTareaCosecha;
use App\Models\UsuarioTareaLote;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlanillaSemanalExport implements FromCollection, WithHeadings, WithStyles
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
        

        $personalFinca = EmpleadoFinca::where('department_id', $this->plansemanal->finca->id)->WhereNotIn('position_id', [15, 9])->get();
        $personalCodigos = $personalFinca->pluck('last_name')->toArray();

        $asignaciones = UsuarioTareaLote::whereIn('codigo', $personalCodigos)->get();
        
        $asignacionesPorEmpleado = UsuarioTareaLote::whereRaw('WEEKOFYEAR(created_at) = ?', [$this->plansemanal->semana])->get()->groupBy('codigo');
        $asignacionesPorEmpleadoCosecha = UsuarioTareaCosecha::whereRaw('WEEKOFYEAR(created_at) = ?', [$this->plansemanal->semana])->get()->groupBy('codigo');

        foreach ($personalFinca as $empleado) {
            
            $asignaciones = $asignacionesPorEmpleado->get($empleado->last_name, collect());
            $asignacionesCosecha = $asignacionesPorEmpleadoCosecha->get($empleado->last_name,collect());
            $empleado->horas_totales = 0;
            $empleado->bono = 0;
            $empleado->septimo = 0;
            $empleado->total_devengar = 0;

            if($asignaciones->isNotEmpty()){
                foreach ($asignaciones as $asignacion) {
                    if($asignacion->tarea_lote->cierre){
                        $empleado->horas_totales += (($asignacion->tarea_lote->horas) / $asignacion->tarea_lote->users->count());
                        $empleado->total_devengar += (($asignacion->tarea_lote->presupuesto) / $asignacion->tarea_lote->users->count());
                    }
                }
                
            }
            
            if($asignacionesCosecha->isNotEmpty()){
                foreach ($asignacionesCosecha as $asignacion) {
                    $asignacionCosecha = AsignacionDiariaCosecha::whereDate('created_at',$asignacion->created_at)->get()->first();
                    if($asignacionCosecha->cierre)
                    {
                        $libras_total_planta = $asignacionCosecha->cierre->libras_total_planta;
                        $cierre = $asignacionCosecha->cierre;
                        if($libras_total_planta){
                            $rendimiento = $asignacion->tarealote->tarea->cultivo->rendimiento;
                           
                            $pesoLbCabeza = $libras_total_planta / $cierre->plantas_cosechadas;
                            $porcentaje = ($asignacion->libras_asignacion/ $cierre->libras_total_finca);
                            $rendimientoTeoricoPorPersona =  round(($pesoLbCabeza * $rendimiento),2);
                            $cabezas_cosechadas = ($porcentaje*$libras_total_planta)/$pesoLbCabeza;
                           
                            $montoTotal = round(((($libras_total_planta/ $rendimientoTeoricoPorPersona) * 8)*11.98),2);
                            $libras_asignacion_planta = round((($porcentaje/100) * $libras_total_planta),4);
                            $horas_cosecha = $cabezas_cosechadas/120;
                            $empleado->horas_totales += $horas_cosecha;
                            $empleado->total_devengar += $montoTotal*$porcentaje;
    
                      
                        }
                    }
                    
                }
                
            }

            if($empleado->horas_totales >= 44){
                $empleado->bono = 250/4.33;
                $empleado->septimo = ($empleado->total_devengar/ 30); 
                $empleado->total_devengar += $empleado->septimo;
                
            }

            $rows->push([
                'CODIGO' => $empleado->last_name,
                'NOMBRE' => $empleado->first_name,
                'HORAS SEMANALES' => $empleado->horas_totales,
                'BONO' => $empleado->bono,
                'SEPTIMO' => $empleado->septimo,
                'TOTAL A DEVENGAR' => ($empleado->total_devengar + $empleado->bono),
            ]);
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:F1')->applyFromArray([
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
        return ['CODIGO', 'NOMBRE', 'HORAS SEMANALES', 'BONO', 'SEPTIMO', 'TOTAL A DEVENGAR'];
    }
}
