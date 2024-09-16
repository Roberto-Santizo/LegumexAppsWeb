<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\User;
use App\Models\Finca;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\PlanSemanal;
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
use Maatwebsite\Excel\Facades\Excel;

class PlanSemanalFincasController extends Controller
{
    protected $semanaService;

    // Inyectar el servicio en el constructor
    public function __construct(SemanaService $semanaService)
    {
        $this->semanaService = $semanaService;
    }

    public function index()
    {
        $planes = PlanSemanalFinca::paginate(10);
        foreach ($planes as $plan) {
            $plan->tareas_totales = 0;
            $plan->totalPersonasNecesarias = $plan->tareasTotales()->orderBy('personas', 'desc')->first();
            foreach ($plan->tareasTotales as $tarea) {
                $plan->presupuesto += $tarea->presupuesto;
                $plan->tareas_totales++;
            }
        }

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

        Excel::import(new PlanSemanalImport, $request->file('file'));

        return redirect()->route('planSemanal')->with('success', 'Plan Semanal Creado Correctamente');
    }


    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->finca->lotes;
        return view('agricola.planSemanal.show', ['lotes' => $lotes, 'planSemanal' => $plansemanalfinca]);
    }

    public function tareasLote(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        // Obtener todas las tareas con asignaciones más recientes y usuarios
        $tareas = $plansemanalfinca->tareasPorLote($lote->id)
            ->with([
                'asignacion' => function ($query) {
                    $query->latest(); // Ordena las asignaciones por fecha
                }
            ])
            ->get();

        // Recorrer las tareas y calcular los datos necesarios
        foreach ($tareas as $tarea) {
            // Contar usuarios asignados hoy
            $tarea->cupos_utilizados = $tarea->users(Carbon::today())->count();

            // Obtener la asignación diaria más reciente
            $tarea->asignacion_diaria = $tarea->asignacion;

            // Inicializar el campo extendido y la cantidad de ingresados
            $tarea->extendido = false;
            $tarea->ingresados = 0;

            if ($tarea->asignacion_diaria) {
                if (!$tarea->asignacion_diaria->created_at->isToday() && !$tarea->cierre) {
                    $tarea->extendido = true;

                    // Obtener los usuarios asignados a la fecha de la asignación diaria
                    $usuariosIds = $tarea->users($tarea->asignacion_diaria->created_at)->pluck('usuario_id');

                    // Obtener los registros de empleados ingresados en la fecha actual
                    $empleadosIngresados = EmpleadoIngresado::whereIn('emp_id', $usuariosIds)
                        ->whereDate('punch_time', Carbon::today())
                        ->orderBy('punch_time', 'desc')
                        ->get();

                    // Contar los registros ingresados
                    $tarea->ingresados = $empleadosIngresados->count();
                }
            }
        }

        return view('agricola.planSemanal.tareasLote', [
            'lote' => $lote,
            'plansemanalfinca' => $plansemanalfinca,
            'tareas' => $tareas
        ]);
    }



    public function AsignarEmpleados(Lote $lote, PlanSemanalFinca $plansemanalfinca, Tarea $tarea, TareasLote $tarealote)
    {
        $asignacionDiaria = AsignacionDiaria::where('tarea_lote_id', $tarealote->id)
            ->whereDate('created_at', Carbon::today())->get();
        if ($asignacionDiaria->count() != 0) {
            return redirect()->route('planSemanal.tareasLote', [$lote, $plansemanalfinca])->with('error', "Esta tarea ya fue cerrada por el día de hoy");
        }
        $asignados = UsuarioTareaLote::where('tarealote_id', $tarealote->id)->whereDate('created_at', Carbon::today())->pluck('usuario_id')->toArray();
        $tarealote->cupos_utilizados = $tarealote->users(Carbon::today())->count();

        $ingresos = EmpleadoIngresado::whereDate('punch_time', Carbon::today())->where('terminal_id', 7)->get();
        $ingresos = $ingresos->filter(function ($ingreso) {
            $ingreso->asignaciones = UsuarioTareaLote::where('usuario_id', $ingreso->emp_id)->whereDate('created_at', Carbon::today())->get();
            $ingreso->horas_totales = 0;
            if ($ingreso->asignaciones->count() > 0) {
                foreach ($ingreso->asignaciones as $asignacion) {
                    $ingreso->horas_totales += ($asignacion->tarea_lote->horas / $asignacion->tarea_lote->personas);
                }
            }
            return $ingreso;
        });



        return view('agricola.planSemanal.asignar', ['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tarea' => $tarea, 'ingresos' => $ingresos, 'tarealote' => $tarealote, 'asignados' => $asignados]);
    }

    public function rendimiento(TareasLote $tarealote, PlanSemanalFinca $plansemanalfinca)
    {
        return view('agricola.plansemanal.rendimiento', ['tarealote' => $tarealote, 'plansemanalfinca' => $plansemanalfinca]);
    }

    public function diario(EmpleadoFinca $usuario, TareasLote $tarealote)
    {
        $tarealote->asignacion = $tarealote->asignaciones()->whereDate('created_at', Carbon::today())->get()->first();
        $usuario->asignacion_usuario_id = UsuarioTareaLote::where('usuario_id', $usuario->id)->where('tarealote_id', $tarealote->id)->whereDate('created_at', Carbon::today())->get()->first();

        $primerMarcaje = EmpleadoIngresado::where('emp_id', $usuario->id) // Filtrar por usuario si es necesario
            ->whereDate('punch_time', Carbon::today())   // Ordenar por la columna 'created_at' en orden descendente
            ->orderBy('punch_time', 'asc')   // Ordenar por la columna 'created_at' en orden descendente
            ->first();

        $ultimoMarcaje = EmpleadoIngresado::where('emp_id', $usuario->id) // Filtrar por usuario si es necesario
            ->whereDate('punch_time', Carbon::today())   // Ordenar por la columna 'created_at' en orden descendente
            ->orderBy('punch_time', 'desc')   // Ordenar por la columna 'created_at' en orden descendente
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

        // Captura la variable $semanaplan con "use"
        $tareasFiltradas = $tareas->filter(function ($tarea) use ($semanaplan) {
            if ($semanaplan < Carbon::now()->weekOfYear) {
                if (!$tarea->cierre) {
                    return $tarea;  // Retorna la tarea si cumple la condición
                }
            }
        });

        return view('agricola.planSemanal.atrasadas', [
            'tareas' => $tareasFiltradas,
            'plansemanalfinca' => $plansemanalfinca
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
