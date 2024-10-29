<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\TareaCosecha;
use Illuminate\Http\Request;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Services\SemanaService;
use App\Models\PlanSemanalFinca;
use App\Models\TareaLoteCosecha;
use App\Models\UsuarioTareaLote;
use App\Models\EmpleadoIngresado;
use App\Exceptions\ImportExeption;
use App\Imports\PlanSemanalImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PlanSemanalFincasController extends Controller
{

    public function index()
    {
        $planes = PlanSemanalFinca::orderBy('semana', 'DESC')->paginate(10);

        $planes->map(function ($plan) {
            $tareasCierre = collect();
            $tareasExtraordinarias = collect();
            $tareasPresupuestadas = collect();
            $tareasCosechasTerminadas = collect();
            // Recorre todas las tareas una sola vez
            foreach ($plan->tareasTotales as $tarea) {
                if ($tarea->cierre) {
                    $tareasCierre->push($tarea);
                }

                if ($tarea->extraordinaria) {
                    $tareasExtraordinarias->push($tarea);
                } else {
                    $tareasPresupuestadas->push($tarea);
                }
            }

            foreach($plan->tareasCosechaTotales as $tarea){
                if($tarea->cierreSemanal){
                    $tareasCosechasTerminadas->push($tarea); 
                }
            }

            // Asigna las tareas a la propiedad del plan
            $plan->tareasRealizadas = $tareasCierre;
            $plan->tareasExtraordinarias = $tareasExtraordinarias;
            $plan->tareasPresupuestadas = $tareasPresupuestadas;
            $plan->tareasCosechasTerminadas = $tareasCosechasTerminadas;

            $plan->tareasExtraordinariasTerminadas = $tareasExtraordinarias->filter(function ($tarea) {
                return $tarea->cierre;
            });

            $plan->tareasPresupuestadasTerminadas = $tareasPresupuestadas->filter(function ($tarea) {
                return $tarea->cierre;
            });

            $plan->presupuesto_extraordinario = $tareasExtraordinarias->sum('presupuesto');
            $plan->presupuesto_extraordinario_gastado = $plan->tareasExtraordinariasTerminadas->sum('presupuesto');

            $plan->presupuesto_general = $tareasPresupuestadas->sum('presupuesto');
            $plan->presupuesto_general_gastado = $plan->tareasPresupuestadasTerminadas->sum('presupuesto');

            return $plan;
        });

        
        return view('agricola.planSemanal.index', compact(['planes']));
    }


    public function create()
    {
        return view('agricola.planSemanal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            Excel::import(new PlanSemanalImport, $request->file('file'));
        } catch (ImportExeption $th) {
            return back()->with('error', $th->getMessage());
        }

        return redirect()->route('planSemanal')->with('success', 'Plan Semanal Creado Correctamente');
    }


    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->tareasTotales()
            ->select('lote_id', DB::raw('SUM(personas) as total_personas'), DB::raw('SUM(presupuesto) as total_presupuesto'), DB::raw('SUM(horas) as total_horas'))
            ->groupBy('lote_id')
            ->get();
        $lotesCosecha = $plansemanalfinca->tareasCosechaTotales()
                ->select('lote_id')
                ->groupBy('lote_id')
                ->get();
        return view('agricola.planSemanal.show', ['lotes' => $lotes, 'plansemanalfinca' => $plansemanalfinca, 'lotesCosecha' => $lotesCosecha]);
    }

    public function tareasLote(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $tareas = $plansemanalfinca->tareasPorLote($lote->id)
            ->with([
                'asignacion' => function ($query) {
                    $query->latest();
                }
            ])
            ->get();
        foreach ($tareas as $tarea) {
            $tarea->cupos_utilizados = $tarea->users(Carbon::today())->count();
            $tarea->asignacion_diaria = $tarea->asignacion;

            $tarea->extendido = false;
            $tarea->ingresados = 0;

            if($tarea->movimientos->count() > 0){
                $tarea->semana_origen = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->semana;
                $tarea->finca = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->finca->finca;
            }
            if ($tarea->asignacion_diaria) {
                if (!$tarea->asignacion_diaria->created_at->isToday() && !$tarea->cierre) {
                    $tarea->extendido = true;

                    $usuariosIds = $tarea->users($tarea->asignacion_diaria->created_at)->pluck('usuario_id');

                    $empleadosIngresados = EmpleadoIngresado::whereIn('emp_id', $usuariosIds)
                        ->whereDate('punch_time', Carbon::today())
                        ->orderBy('punch_time', 'desc')
                        ->get();

                    $tarea->ingresados = $empleadosIngresados->count();
                }
            }
        }

        return view('agricola.planSemanal.tareasLote', [
            'lote' => $lote,
            'plansemanalfinca' => $plansemanalfinca,
            'tareas' => $tareas,
            'semanaActual' => Carbon::now()->weekOfYear
        ]);
    }

    public function tareasCosechaLote(Lote $lote,PlanSemanalFinca $plansemanalfinca)
    {
        $tarea = $plansemanalfinca->tareaCosechaPorLote($lote->id)->with('asignaciones.cierre')->with('cierres')->first();
        return view('agricola.planSemanal.tareasLoteCosecha', ['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca,'tarea' => $tarea, 'semanaActual' => Carbon::now()->weekOfYear]);
    }

    public function tareasCosechaLoteRendimiento(Lote $lote, PlanSemanalFinca $plansemanalfinca, TareaLoteCosecha $tarealotecosecha)
    {
        $hoy = Carbon::today();
        return view('agricola.tareasCosechaLote.rendimiento',compact(['lote','plansemanalfinca','tarealotecosecha']));
    }

    public function tareasCosechaLoteRendimientoReal(Lote $lote, PlanSemanalFinca $plansemanalfinca, TareaLoteCosecha $tarealotecosecha)
    {
        $hoy = Carbon::today();
        return view('agricola.tareasCosechaLote.rendimientoReal',compact(['lote','plansemanalfinca','tarealotecosecha']));
    }



    public function AsignarEmpleados(Lote $lote, PlanSemanalFinca $plansemanalfinca, Tarea $tarea, TareasLote $tarealote)
    {
        return view('agricola.planSemanal.asignar',compact(['lote','plansemanalfinca','tarea','tarealote']));
    }

    public function AsignarEmpleadosCosecha(Lote $lote, PlanSemanalFinca $plansemanalfinca,  TareaCosecha $tarea , TareaLoteCosecha $tarealotecosecha)
    {
        return view('agricola.planSemanal.asignarCosecha',compact(['lote','plansemanalfinca','tarea','tarealotecosecha']));
    }


    public function rendimiento(TareasLote $tarealote, PlanSemanalFinca $plansemanalfinca)
    {
        return view('agricola.plansemanal.rendimiento', ['tarealote' => $tarealote, 'plansemanalfinca' => $plansemanalfinca]);
    }

    public function diario(EmpleadoFinca $usuario, TareasLote $tarealote)
    {
        $tarealote->asignacion = $tarealote->asignaciones()->whereDate('created_at', Carbon::today())->get()->first();
        $usuario->asignacion_usuario_id = UsuarioTareaLote::where('usuario_id', $usuario->id)->where('tarealote_id', $tarealote->id)->whereDate('created_at', Carbon::today())->get()->first();

        $primerMarcaje = EmpleadoIngresado::where('emp_id', $usuario->id)
            ->whereDate('punch_time', Carbon::today())
            ->orderBy('punch_time', 'asc')
            ->first();

        $ultimoMarcaje = EmpleadoIngresado::where('emp_id', $usuario->id)
            ->whereDate('punch_time', Carbon::today())
            ->orderBy('punch_time', 'desc')
            ->first();

        return view('agricola.plansemanal.diario', ['tarealote' => $tarealote, 'usuario' => $usuario, 'primerMarcaje' => $primerMarcaje, 'ultimoMarcaje' => $ultimoMarcaje]);
    }


    public function atrasadas(Request $request, PlanSemanalFinca $plansemanalfinca)
    {
       
        return view('agricola.planSemanal.atrasadas', compact(['plansemanalfinca']));
    }

}
