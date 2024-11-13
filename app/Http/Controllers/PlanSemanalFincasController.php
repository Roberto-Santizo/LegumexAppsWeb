<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\TareaCosecha;
use Illuminate\Http\Request;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
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
        return view('agricola.planSemanal.index');
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

        $lotesCosecha = $plansemanalfinca->tareasCosechaTotales()
                ->select('lote_id')
                ->groupBy('lote_id')
                ->get();
        return view('agricola.planSemanal.show', compact(['lotes','plansemanalfinca','lotesCosecha']));
    }

    public function tareasLote(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $semanaActual = Carbon::now()->weekOfYear;
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
        return view('agricola.planSemanal.tareasLote', compact(['lote','plansemanalfinca','tareas','semanaActual']));
    }

    public function tareasCosechaLote(Lote $lote,PlanSemanalFinca $plansemanalfinca)
    {
        $semanaActual = Carbon::now()->weekOfYear;
        $tarea = $plansemanalfinca->tareaCosechaPorLote($lote->id)->with('asignaciones.cierre')->with('cierres')->first();
        return view('agricola.planSemanal.tareasLoteCosecha', compact(['lote','plansemanalfinca','tarea','semanaActual']));
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
        return view('agricola.plansemanal.rendimiento', compact(['tarealote','plansemanalfinca']));
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

        return view('agricola.plansemanal.diario', compact(['tarealote','usuarios','primerMarcaje','ultimoMarcaje']));
    }


    public function atrasadas(Request $request, PlanSemanalFinca $plansemanalfinca)
    {
        return view('agricola.planSemanal.atrasadas', compact(['plansemanalfinca']));
    }

}
