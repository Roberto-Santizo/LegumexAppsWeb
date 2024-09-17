<?php

namespace App\Exports;

use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\EmpleadoIngresado;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlanillaSemanalExport implements FromCollection, WithHeadings
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
        Carbon::setLocale('es');
        $personalFinca = EmpleadoFinca::where('department_id', $plansemanal->finca->id)->WhereNotIn('position_id', [15, 9])->get();


        foreach ($personalFinca as $empleado) {
            $rows->push([
                'CODIGO' => $empleado->last_name,
                'NOMBRE' => $empleado->first_name,
                // 'MONTO TAREAS' => $lote->nombre,
                // 'BONO' => $tarea->tarea->tarea,
                // 'SEPTIMO' => ($asignacion->tarea_lote->cierre) ? (($asignacion->tarea_lote->presupuesto) / $tarea->users->count()) : '0',
                // 'TOTAL A DEVENGAR' => ($asignacion->tarea_lote->cierre) ? ($asignacion->tarea_lote->horas_persona) : '0',
            ]);
        }
        // foreach ($plansemanal->finca->lotes as $lote) {

        //     foreach ($lote->tareas as $tarea) {
        //         $carbonFecha = null;
        //         if ($tarea->asignacion) {
        //             // Formatear la fecha directamente si existe el cierre
        //             $carbonFecha = $tarea->asignacion->created_at->locale('es')->isoFormat('dddd');
        //         }

        //         if (!($tarea->users)->isEmpty()) {
        //             foreach ($tarea->users as $asignacion) {
        //                 $empleado = EmpleadoFinca::where('id', $plansemanal->finca->id)->get()->first();
        //                 dd($empleado);
        //                 $rows->push([
        //                     'CODIGO' => $empleado->last_name,
        //                     'NOMBRE' => $empleado->first_name,
        //                     // 'MONTO TAREAS' => $lote->nombre,
        //                     // 'BONO' => $tarea->tarea->tarea,
        //                     // 'SEPTIMO' => ($asignacion->tarea_lote->cierre) ? (($asignacion->tarea_lote->presupuesto) / $tarea->users->count()) : '0',
        //                     // 'TOTAL A DEVENGAR' => ($asignacion->tarea_lote->cierre) ? ($asignacion->tarea_lote->horas_persona) : '0',
        //                 ]);
        //             }
        //         }
        //     }
        // }

        return $rows;
    }

    public function headings(): array
    {
        return ['CODIGO', 'NOMBRE', 'MONTO TAREAS', 'BONO', 'SEPTIMO', 'TOTAL A DEVENGAR'];
    }
}
