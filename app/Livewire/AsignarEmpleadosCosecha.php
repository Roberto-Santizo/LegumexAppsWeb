<?php

namespace App\Livewire;

use App\Models\AsignacionDiariaCosecha;
use Livewire\Component;
use App\Models\EmpleadoFinca;
use App\Models\UsuarioTareaLote;
use App\Models\EmpleadoIngresado;
use App\Models\UsuarioTareaCosecha;
use Carbon\Carbon;

class AsignarEmpleadosCosecha extends Component
{
    public $plansemanalfinca;
    public $lote;
    public $tarea;
    public $tarealotecosecha;
    public $hoy;
    public $ingresos;
    public $asignados;
    public $rendimiento = 960;
    public $total = 0;
    protected $listeners = ['AsignarEmpleado','DesasignarEmpleado','cerrarAsignacion'];


    public function mount()
    {
       $this->actualizarIngresos();
    }

    public function AsignarEmpleado(EmpleadoFinca $empleado)
    {
        UsuarioTareaCosecha::create([
            'usuario_id' => $empleado->id,
            'tarealotecosecha_id' => $this->tarealotecosecha->id,
            'nombre' => $empleado->first_name,
            'codigo' => $empleado->last_name
        ]);
        $this->total = $this->tarealotecosecha->users->count() * 960;
        $this->actualizarIngresos();
    }

    public function DesasignarEmpleado(UsuarioTareaCosecha $asignacion)
    {
        $asignacion->delete();
        $this->total = $this->tarealotecosecha->users->count() * 960;
        $this->actualizarIngresos();
    }

    public function cerrarAsignacion()
    {
        AsignacionDiariaCosecha::create([
            'tarea_lote_cosecha_id' => $this->tarealotecosecha->id
        ]);

        return redirect()->route('planSemanal.tareasCosechaLote',[$this->lote, $this->plansemanalfinca])->with('success','Asignación cerrada correctamente');
    }

    private function actualizarIngresos()
    {
        $hoy = Carbon::today();
        $this->ingresos = EmpleadoIngresado::whereDate('punch_time', $hoy)
        ->get()
        ->map(function ($ingreso) use ($hoy) {
            $asignaciones = UsuarioTareaLote::where('usuario_id', $ingreso->emp_id)
                ->whereDate('created_at', $hoy)
                ->get();

            $horas_totales = $asignaciones->sum(function ($asignacion) {
                return $asignacion->tarea_lote->horas / $asignacion->tarea_lote->users->count();
            });

            $ingreso->asignaciones = $asignaciones;
            $ingreso->horas_totales = $horas_totales;

            return $ingreso;
        });

        $this->asignados = $this->tarealotecosecha->users()->whereDate('created_at',$hoy)->get(); 
        $asignadosIds = $this->asignados->pluck('usuario_id')->toArray();
        $this->ingresos = $this->ingresos->filter(function($ingreso) use ($asignadosIds) {
            return !in_array($ingreso->emp_id, $asignadosIds);
        });

    }

    public function render()
    {
        return view('livewire.asignar-empleados-cosecha');
    }
}
