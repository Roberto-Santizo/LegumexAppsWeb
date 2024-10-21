<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use App\Exports\PlansemanalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanillaSemanalExport;
use App\Exports\PlanControlPresupuestoExport;
use App\Exports\UsuariosCosechaExport;
use App\Models\TareaLoteCosecha;

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

    public function ControlPresupuesto($semana)
    {
        $fileName = 'Control Tareas ' . $semana .'.xlsx';
        return Excel::download(new PlanControlPresupuestoExport($semana), $fileName);
    }

    public function ControlCosecha(TareaLoteCosecha $tarealotecosecha)
    {
        $fileName = 'Control de cosechas.xlsx';
        return Excel::download(new UsuariosCosechaExport($tarealotecosecha),$fileName);
    }
}
