<?php

namespace App\Http\Controllers;

use App\Exports\LoteHistoricoTareasExport;
use App\Exports\LotesHistoricoTareasExport;
use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use App\Exports\PlansemanalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanillaSemanalExport;
use App\Exports\PlanControlPresupuestoExport;
use App\Exports\UsuariosCosechaExport;
use App\Models\Finca;
use App\Models\Lote;
use App\Models\TareaLoteCosecha;

class ReporteController extends Controller 
{
    public function PlanSemanal(PlanSemanalFinca $planSemanalFinca)
    {
        $fileName = 'Plan Semanal ' . $planSemanalFinca->finca->finca . ' S' . $planSemanalFinca->semana . '.xlsx';
        try {
            return Excel::download(new PlansemanalExport($planSemanalFinca), $fileName);
        } catch (\Throwable $th) {
            return redirect()->route('planSemanal')->with('error','Existe un error al descargar el reporte');
        }
    }

    public function PlanillaSemanal(PlanSemanalFinca $planSemanalFinca)
    {
        $fileName = 'Planilla Semanal ' . $planSemanalFinca->finca->finca . ' S' . $planSemanalFinca->semana . '.xlsx';

        try {
            return Excel::download(new PlanillaSemanalExport($planSemanalFinca), $fileName);
        } catch (\Throwable $th) {
            return redirect()->route('planSemanal')->with('error','Existe un error al descargar el reporte');
        }
    }

    public function ControlPresupuesto($semana)
    {
        $fileName = 'Control Tareas ' . $semana .'.xlsx';
        try {
            return Excel::download(new PlanControlPresupuestoExport($semana), $fileName);
        } catch (\Throwable $th) {
            return redirect()->route('planSemanal')->with('error','Existe un error al descargar el reporte');
        }
    }

    public function ControlCosecha(TareaLoteCosecha $tarealotecosecha)
    {
        $fileName = 'Control de cosechas.xlsx';
        try {
            //code...
            return Excel::download(new UsuariosCosechaExport($tarealotecosecha),$fileName);
        } catch (\Throwable $th) {
            return redirect()->route('planSemanal')->with('error','Existe un error al descargar el reporte');
        }
    }

    public function historicoLote(Lote $lote)
    {
       $fileName = 'Control de tareas historico ' . $lote->nombre . '.xlsx';
       try {
           return Excel::download(new LoteHistoricoTareasExport($lote),$fileName);
       } catch (\Throwable $th) {
        return redirect()->route('planSemanal')->with('error','Existe un error al descargar el reporte');
       }
    }

    public function HistoricoLotesFinca(Finca $finca)
    {
        $fileName = 'Control de tareas historico ' . $finca->finca . '.xlsx';
        $lotes = $finca->lotes;
       try {
           return Excel::download(new LotesHistoricoTareasExport($lotes),$fileName);
       } catch (\Throwable $th) {
        return redirect()->route('fincas')->with('error','Existe un error al descargar el reporte');
       }
    }
}
