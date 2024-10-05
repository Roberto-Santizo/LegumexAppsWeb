<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportExeption;
use App\Models\Lote;
use App\Models\Tarea;
use App\Models\TareasLote;
use Illuminate\Http\Request;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Services\SemanaService;
use App\Models\AsignacionDiaria;
use App\Models\PlanSemanalFinca;
use App\Models\UsuarioTareaLote;
use App\Models\EmpleadoIngresado;
use App\Models\RendimientoDiario;
use App\Imports\PlanSemanalImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PlanSemanalFincasController extends Controller
{
    protected $semanaService;

    public function __construct(SemanaService $semanaService)
    {
        $this->semanaService = $semanaService;
    }

    public function index()
    {
        $planes = PlanSemanalFinca::orderBy('semana', 'DESC')->paginate(10);

        $planes->map(function ($plan) {
            // Inicializa las colecciones necesarias
            $tareasCierre = collect();
            $tareasExtraordinarias = collect();
            $tareasPresupuestadas = collect();

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

            // Asigna las tareas a la propiedad del plan
            $plan->tareasRealizadas = $tareasCierre;
            $plan->tareasExtraordinarias = $tareasExtraordinarias;
            $plan->tareasPresupuestadas = $tareasPresupuestadas;

            // Calcula las tareas extraordinarias terminadas
            $plan->tareasExtraordinariasTerminadas = $tareasExtraordinarias->filter(function ($tarea) {
                return $tarea->cierre;
            });

            // Calcula las tareas presupuestadas terminadas
            $plan->tareasPresupuestadasTerminadas = $tareasPresupuestadas->filter(function ($tarea) {
                return $tarea->cierre;
            });

            // Calcula los presupuestos
            $plan->presupuesto_extraordinario = $tareasExtraordinarias->sum('presupuesto');
            $plan->presupuesto_extraordinario_gastado = $plan->tareasExtraordinariasTerminadas->sum('presupuesto');

            $plan->presupuesto_general = $tareasPresupuestadas->sum('presupuesto');
            $plan->presupuesto_general_gastado = $plan->tareasPresupuestadasTerminadas->sum('presupuesto');

            return $plan;
        });

        
        return view('agricola.planSemanal.index', ['planes' => $planes]);
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


    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->tareasTotales()
            ->select('lote_id', DB::raw('SUM(personas) as total_personas'), DB::raw('SUM(presupuesto) as total_presupuesto'), DB::raw('SUM(horas) as total_horas'))
            ->groupBy('lote_id')
            ->get();
        return view('agricola.planSemanal.show', ['lotes' => $lotes, 'planSemanal' => $plansemanalfinca]);
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

    public function storeDiario(Request $request)
    {
        $request->validate([
            'tarea_lote_id' => 'required'
        ]);
        try {
            RendimientoDiario::create([
                'tarea_lote_id' => $request->tarea_lote_id,
                'terminado' => 1
            ]);

            return redirect()->back()->with('success', 'La tarea fue completada con exito');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Hubo un error al guardar el registro');
        }
    }

    public function atrasadas(Request $request, PlanSemanalFinca $plansemanalfinca)
    {
        $semanaplan = $plansemanalfinca->semana;
        $tareas = $plansemanalfinca->tareasTotales;

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

        return view('agricola.planSemanal.atrasadas', [
            'tareas' => $tareasFiltradas,
            'plansemanalfinca' => $plansemanalfinca,
            'atrasadas' => true
        ]);
    }

    public function crt(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $fechasSemana = $this->semanaService->obtenerFechasDeSemana($plansemanalfinca->semana);

        $tareas = $plansemanalfinca->tareasPorLote($lote->id)->get();

        // $terminados = 0;
        // foreach ($tareas as $tarea) {
        //     foreach ($tarea->asignaciones as $asignacion) {
        //         Rendi
        //         $terminados 
        //     }
        // }

        // dd($tareas);

        return view('agricola.plansemanal.crt', ['fechasSemana' => $fechasSemana, 'lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tareas' => $tareas]);
    }
}
