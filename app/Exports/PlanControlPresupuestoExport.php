<?php

namespace App\Exports;

use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\UsuarioTareaLote;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlanControlPresupuestoExport implements FromCollection, WithHeadings, WithStyles
{

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $rows = collect();
        Carbon::setLocale('es');
        $planes = PlanSemanalFinca::where('semana', Carbon::now()->weekOfYear())->get();

        $planes->map(function ($plan) use($rows) {
            // Inicializa las colecciones necesarias
            $tareasCierre = collect();
            $tareasExtraordinarias = collect();
            $tareasPresupuestadas = collect();

            // Recorre todas las tareas una sola vez
            foreach ($plan->tareasTotales as $tarea) {
                if ($tarea->cierre) {
                    $tareasCierre->push($tarea);
                }

                if ($tarea->extraordinaria) {
                    $tareasExtraordinarias->push($tarea);
                } else {
                    $tareasPresupuestadas->push($tarea);
                }
            }

            // Asigna las tareas a la propiedad del plan
            $plan->tareasRealizadas = $tareasCierre;
            $plan->tareasExtraordinarias = $tareasExtraordinarias;
            $plan->tareasPresupuestadas = $tareasPresupuestadas;

            // Calcula las tareas extraordinarias terminadas
            $plan->tareasExtraordinariasTerminadas = $tareasExtraordinarias->filter(function ($tarea) {
                return $tarea->cierre;
            });

            // Calcula las tareas presupuestadas terminadas
            $plan->tareasPresupuestadasTerminadas = $tareasPresupuestadas->filter(function ($tarea) {
                return $tarea->cierre;
            });

            // Calcula los presupuestos
            $plan->presupuesto_extraordinario = $tareasExtraordinarias->sum('presupuesto');
            $plan->presupuesto_extraordinario_gastado = $plan->tareasExtraordinariasTerminadas->sum('presupuesto');

            $plan->presupuesto_general = $tareasPresupuestadas->sum('presupuesto');
            $plan->presupuesto_general_gastado = $plan->tareasPresupuestadasTerminadas->sum('presupuesto');

            $rows->push([
                'CODIGO' => $plan->finca->code,
                'FINCA' => $plan->finca->finca,
                'SEMANA' => $plan->semana,
                'PRESUPUESTO GENERAL' => $plan->presupuesto_general,
                'PRESUPUESTO GENERAL GASTADO' => $plan->presupuesto_general_gastado ?? 0,
                'MONTO EXTRAORDINARIO' => $plan->presupuesto_extraordinario ?? 0,
                'MONTO EXTRAORDINARIO GASTADO' => $plan->presupuesto_extraordinario_gastado ?? 0,
                'TOTAL DE TAREAS PRESUPUESTADAS' => $tareasPresupuestadas->count(),
                'TOTAL DE TAREAS EXTRAORDINARIAS' => $tareasExtraordinarias->count() ?? 0,
            ]);
        });

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:H1')->applyFromArray([
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
        return ['CODIGO', 'FINCA','SEMANA', 'PRESUPUESTO', 'PRESUPUESTO GASTADO', 'MONTO EXTRAORDINARIO', 'MONTO EXTRAORDINARIO GASTADO', 'TOTAL DE TAREAS PRESUPUESTADAS','TOTAL DE TAREAS EXTRAORDINARIAS'];
    }
}
