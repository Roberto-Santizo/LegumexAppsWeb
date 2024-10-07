<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use App\Exports\PlansemanalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanillaSemanalExport;
use App\Exports\PlanControlPresupuestoExport;

class ReporteController extends Controller 
{
    public function PlanSemanal(PlanSemanalFinca $planSemanalFinca)
    {
        $fileName = 'Plan Semanal ' . $planSemanalFinca->finca->finca . ' S' . $planSemanalFinca->semana . '.xlsx';
        return Excel::download(new PlansemanalExport($planSemanalFinca), $fileName);
    }

    public function PlanillaSemanal(PlanSemanalFinca $planSemanalFinca)
    {
        $fileName = 'Planilla Semanal ' . $planSemanalFinca->finca->finca . ' S' . $planSemanalFinca->semana . '.xlsx';
        return Excel::download(new PlanillaSemanalExport($planSemanalFinca), $fileName);
    }

    public function ControlPresupuesto()
    {
        $semanaActual = Carbon::now()->weekOfYear();
        $fileName = 'Control Tareas ' . $semanaActual .'.xlsx';
        return Excel::download(new PlanControlPresupuestoExport, $fileName);
    }
}
