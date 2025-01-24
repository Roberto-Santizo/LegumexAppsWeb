<?php

namespace App\Http\Controllers;

use App\Exports\LoteHistoricoTareasExport;
use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use App\Exports\PlansemanalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanillaSemanalExport;
use App\Exports\PlanControlPresupuestoExport;
use App\Exports\UsuariosCosechaExport;
use App\Models\Lote;
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

    public function historicoLote(Lote $lote)
    {
       $fileName = 'Control de tareas historico ' . $lote->nombre . '.xlsx';
       return Excel::download(new LoteHistoricoTareasExport($lote),$fileName);
    }
}
