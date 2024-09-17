<?php

namespace App\Http\Controllers;

use App\Exports\PlanillaSemanalExport;
use App\Exports\PlansemanalExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller 
{
    public function PlanSemanal($id)
    {
        return Excel::download(new PlansemanalExport($id), 'reporte.xlsx');
    }

    public function PlanillaSemanal($id)
    {
        return Excel::download(new PlanillaSemanalExport($id), 'reporte.xlsx');
    }
}
