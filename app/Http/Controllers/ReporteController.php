<?php

namespace App\Http\Controllers;

use App\Exports\PlansemanalExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function PlanSemanalDiario()
    {
        return Excel::download(new PlansemanalExport, 'reporte.xlsx');
    }
}
