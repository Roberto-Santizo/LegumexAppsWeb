<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Tarea;
use App\Models\TareasLote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AsignacionDiaria;
use App\Models\PlanSemanalFinca;
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

            $plan->tareasRealizadas = $tareasCierre;
            $plan->tareasExtraordinarias = $tareasExtraordinarias;
            $plan->tareasPresupuestadas = $tareasPresupuestadas;

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
            'file' => 'required'
        ]);

        try {
            Excel::import(new PlanSemanalImport, $request->file('file'));
        } catch (ImportExeption $th) {
            return back()->with('error', $th->getMessage());
        }

        return redirect()->route('planSemanal')->with('success', 'Plan Semanal Creado Correctamente');
    }
    
    public function AsignarEmpleados(Lote $lote, PlanSemanalFinca $plansemanalfinca, Tarea $tarea, TareasLote $tarealote)
    {
        $hoy = Carbon::today();
        $semanaActual = Carbon::now()->weekOfYear;

        if ($plansemanalfinca->semana < $semanaActual) {
            return redirect()->route('planSemanal.tareasLote', [$lote, $plansemanalfinca])
                ->with('error', 'El periodo de asignación de esta tarea terminó');
        }

        if (AsignacionDiaria::where('tarea_lote_id', $tarealote->id)
            ->whereDate('created_at', $hoy)->exists()
        ) {
            return redirect()->route('planSemanal.tareasLote', [$lote, $plansemanalfinca])
                ->with('error', "Esta tarea ya fue cerrada por el día de hoy");
        }

        $asignados = UsuarioTareaLote::where('tarealote_id', $tarealote->id)
            ->whereDate('created_at', $hoy)
            ->pluck('usuario_id')
            ->toArray();

        $tarealote->cupos_utilizados = $tarealote->users($hoy)->count();

        $ingresos = EmpleadoIngresado::whereDate('punch_time', $hoy)
            ->where('terminal_id', 7)
            ->get()
            ->map(function ($ingreso) use ($hoy) {
                $asignaciones = UsuarioTareaLote::where('usuario_id', $ingreso->emp_id)
                    ->whereDate('created_at', $hoy)
                    ->get();

                $horas_totales = $asignaciones->sum(function ($asignacion) {
                    return $asignacion->tarea_lote->horas / ($asignacion->tarea_lote->personas - $asignacion->tarea_lote->cupos);
                });

                $ingreso->asignaciones = $asignaciones;
                $ingreso->horas_totales = $horas_totales;

                return $ingreso;
            });

        // Devolver vista con los datos necesarios
        return view('agricola.planSemanal.asignar', [
            'lote' => $lote,
            'plansemanalfinca' => $plansemanalfinca,
            'tarea' => $tarea,
            'ingresos' => $ingresos,
            'tarealote' => $tarealote,
            'asignados' => $asignados,
            'hoy' => $hoy->format('d-m-Y')
        ]);
    }

    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->tareasTotales()
                ->select(
                    'lote_id', 
                    DB::raw('SUM(personas) as total_personas'),
                    DB::raw('SUM(presupuesto) as total_presupuesto'),
                    DB::raw('SUM(horas) as total_horas'),
                    DB::raw('COUNT(tareas_lotes.id) as total_asignadas'), 
                    DB::raw('COUNT(cierre.id) as total_terminadas')       
                )
                ->leftJoin('rendimiento_diarios as cierre', 'tareas_lotes.id', '=', 'cierre.tarea_lote_id') 
                ->groupBy('lote_id')
                ->get();

        return view('agricola.planSemanal.show', compact(['lotes','plansemanalfinca']));
    }

    public function tareasLote(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {

        return view('agricola.planSemanal.tareasLote', compact(['lote','plansemanalfinca']));
    }

    public function atrasadas(Request $request, PlanSemanalFinca $plansemanalfinca)
    {
        $semanaplan = $plansemanalfinca->semana;
        $tareas = $plansemanalfinca->tareasTotales;
        $atrasadas = true;
        $tareasFiltradas = $tareas->filter(function ($tarea) use ($semanaplan) {
            if ($semanaplan < Carbon::now()->weekOfYear) {
                if (!$tarea->cierre) {
                    if($tarea->movimientos->count() > 0){
                        $tarea->semana_origen = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->semana;
                        $tarea->finca = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->finca->finca;
                    }
                    return $tarea;
                }
            }
        });

        dd($tareasFiltradas);
        return view('agricola.planSemanal.atrasadas', ['tareasFiltradas','plansemanalfinca','atrasadas']);
    }

}
