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
use App\Imports\TareasLotesImport;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

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
            foreach ($plan->tareasTotales as $tarea) {
                $plan->presupuesto += $tarea->presupuesto;
                $plan->total_personas += $tarea->personas;
                $plan->tareas_totales++;
            }
        }

        return view('agricola.planSemanal.index', ['planes' => $planes]);
    }


    public function create()
    {
        $fincas = Finca::all();
        return view('agricola.planSemanal.create', ['fincas' => $fincas]);
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
            return redirect()->back()->with('error', 'Existe un error al crear el plan semanal');
        }

        return redirect()->route('planSemanal')->with('success', 'Plan Semanal Creado Correctamente');
    }

    public function show(PlanSemanalFinca $plansemanalfinca)
    {
        $lotes = $plansemanalfinca->finca->lotes;
        return view('agricola.planSemanal.show', ['lotes' => $lotes, 'planSemanal' => $plansemanalfinca]);
    }

    public function tareasLote(Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $tareas = $plansemanalfinca->tareasPorLote($lote->id)->get();
        return view('agricola.planSemanal.tareasLote', ['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tareas' => $tareas]);
    }

    public function AsignarEmpleados(Lote $lote, PlanSemanalFinca $plansemanalfinca, Tarea $tarea, TareasLote $tarealote)
    {
        $asignacionDiaria = AsignacionDiaria::where('tarea_lote_id', $tarealote->id)
            ->whereDate('created_at', Carbon::today())->get();
        if ($asignacionDiaria->count() != 0) {
            return redirect()->route('planSemanal.tareasLote', [$lote, $plansemanalfinca])->with('error', "Esta tarea ya fue cerrada por el día de hoy");
        }
        $ingresos = EmpleadoIngresado::whereDate('punch_time', Carbon::today())->where('terminal_id', 7)->get();
        $asignados = UsuarioTareaLote::where('tarealote_id', $tarealote->id)->whereDate('created_at',Carbon::today())->pluck('usuario_id')->toArray();

        foreach ($ingresos as $ingreso) {
            $ingreso->total_asignaciones = UsuarioTareaLote::where('usuario_id', $ingreso->emp_id)->count();
        }

        return view('agricola.planSemanal.asignar', ['lote' => $lote, 'plansemanalfinca' => $plansemanalfinca, 'tarea' => $tarea, 'ingresos' => $ingresos, 'tarealote' => $tarealote, 'asignados' => $asignados]);
    }

    public function rendimiento(TareasLote $tarealote)
    {
        $usuarios = $tarealote->usuarios;
        foreach ($usuarios as $usuario) {
            $usuario->usuario = EmpleadoFinca::find($usuario->usuario_id);
        }

        return view('agricola.plansemanal.rendimiento', ['tarealote' => $tarealote, 'usuarios' => $usuarios]);
    }

    public function diario(EmpleadoFinca $usuario, TareasLote $tarealote)
    {
        $primerMarcaje = EmpleadoIngresado::where('emp_id', $usuario->id) // Filtrar por usuario si es necesario
            ->whereDate('punch_time', Carbon::today())   // Ordenar por la columna 'created_at' en orden descendente
            ->orderBy('punch_time', 'asc')   // Ordenar por la columna 'created_at' en orden descendente
            ->first();

        $ultimoMarcaje = EmpleadoIngresado::where('emp_id', $usuario->id) // Filtrar por usuario si es necesario
            ->whereDate('punch_time', Carbon::today())   // Ordenar por la columna 'created_at' en orden descendente
            ->orderBy('punch_time', 'desc')   // Ordenar por la columna 'created_at' en orden descendente
            ->first();

        return view('agricola.plansemanal.diario',['tarealote' => $tarealote,'usuario' => $usuario ,'primerMarcaje' => $primerMarcaje, 'ultimoMarcaje' => $ultimoMarcaje]);
    }

    public function crt(Request $request, Lote $lote, PlanSemanalFinca $plansemanalfinca)
    {
        $fechasSemana = $this->semanaService->obtenerFechasDeSemana($plansemanalfinca->semana);

        $tareas = $plansemanalfinca->tareasPorLote($lote->id)->get();
        return view('agricola.plansemanal.crt',['fechasSemana' => $fechasSemana,'lote'=> $lote,'plansemanalfinca' => $plansemanalfinca, 'tareas' => $tareas]);
    }
}
