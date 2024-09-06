<?php

namespace App\Http\Controllers;

use App\Exports\PlansemanalExport;
use App\Models\PlanSemanalFinca;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller 
{
    public function PlanSemanalDiario($id)
    {
        return Excel::download(new PlansemanalExport($id), 'reporte.xlsx');
    }
}
