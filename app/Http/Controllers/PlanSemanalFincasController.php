<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Finca;
use App\Models\PlanSemanal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Imports\TareasLotesImport;
use App\Models\EmpleadoFinca;
use App\Models\EmpleadoIngresado;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PlanSemanalFincasController extends Controller
{

    public function index()
    {
        $planes = PlanSemanalFinca::paginate(10);
        foreach ($planes as $plan) {
            $plan->tareas_totales = 0;
            foreach ($plan->tareasTotales as $tarea) {
                $plan->presupuesto += $tarea->presupuesto;
                $plan->total_personas += $tarea->personas;
                $plan->tareas_totales++;
            }
        }

        return view('agricola.planSemanal.index',['planes' => $planes]);
    }


    public function create()
    {
        $fincas = Finca::all();
        return view('agricola.planSemanal.create',['fincas' => $fincas]);
    }


    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->validate([
                    'finca_id' => 'required',
                    'file' => 'required'
                ]);
        
                $planSemanal = PlanSemanalFinca::create([
                    'finca_id' => $request->finca_id,
                    'semana' => Carbon::now()->weekOfYear
                ]);
        
                Excel::import(new TareasLotesImport($planSemanal), $request->file('file'));
        
            });
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Existe un error al crear el plan semanal');
        }
       
        return redirect()->route('planSemanal')->with('success','Plan Semanal Creado Correctamente');
    }

    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->finca->lotes;
        return view('agricola.planSemanal.show',['lotes' => $lotes,'planSemanal' => $plansemanalfinca]);
    }

    public function tareasLote(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $tareas = $plansemanalfinca->tareasPorLote($lote->id)->get();
        return view('agricola.planSemanal.tareasLote',['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tareas' => $tareas]);
    }

    public function AsignarEmpleados(Lote $lote, PlanSemanalFinca $plansemanalfinca,Tarea $tarea, TareasLote $tarealote)
    {
        $ingresos = EmpleadoIngresado::whereDate('punch_time',Carbon::today())->where('terminal_id',7)->get();
        return view('agricola.planSemanal.asignar',['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tarea' => $tarea, 'ingresos' => $ingresos, 'tarealote' => $tarealote]);
    }

}
