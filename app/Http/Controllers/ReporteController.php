<?php

namespace App\Http\Controllers;

use App\Exports\PlanillaSemanalExport;
use App\Exports\PlansemanalExport;
use App\Models\PlanSemanalFinca;
use Maatwebsite\Excel\Facades\Excel;

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
}
