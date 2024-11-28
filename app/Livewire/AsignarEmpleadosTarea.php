<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmpleadoFinca;
use Illuminate\Support\Carbon;
use App\Models\AsignacionDiaria;
use App\Models\UsuarioTareaLote;
use App\Models\EmpleadoIngresado;
use App\Models\AsignacionTareaLoteDron;

class AsignarEmpleadosTarea extends Component
{
    public $plansemanalfinca;
    public $lote;
    public $tarea;
    public $tarealote;
    public $hoy;
    public $alertas;
    public $ingresos;
    public $cuposMinimos;
    public $asignados;
    public $use_dron = false;

    protected $listeners = ['AsignarEmpleado','DesasignarEmpleado','cerrarAsignacion','cerrarAsignacionForzada','AsignarDron'];
    
    public function mount()
    {
        $this->cuposMinimos = ceil($this->tarealote->horas / 12);
        $this->actualizarIngresos();
    }

    public function AsignarEmpleado(EmpleadoFinca $empleado)
    {
        if($this->tarealote->cupos === 0){
            $this->addError('error', 'No hay cupos disponibles para esta tarea.');
            $this->actualizarIngresos();
            return;
        }
        UsuarioTareaLote::create([
            'usuario_id' => $empleado->id,
            'tarealote_id' => $this->tarealote->id,
            'nombre' => $empleado->first_name,
            'codigo' => $empleado->last_name
        ]);
        $this->tarealote->cupos--;
        $this->tarealote->save();
        $this->actualizarIngresos();
    }
    
    public function DesasignarEmpleado(UsuarioTareaLote $asignacion)
    {
        $asignacion->delete();
        $this->tarealote->cupos++;
        $this->tarealote->save();
        $this->actualizarIngresos();
    }

    private function actualizarIngresos()
    {
        $hoy = Carbon::today();
        $this->ingresos = EmpleadoIngresado::whereDate('punch_time', $hoy)
        ->where('terminal_id',$this->plansemanalfinca->finca->terminal_id)
        ->get()
        ->map(function ($ingreso) use ($hoy) {
            $asignaciones = UsuarioTareaLote::where('usuario_id', $ingreso->emp_id)
                ->whereDate('created_at', $hoy)
                ->get();

            $horas_totales = $asignaciones->sum(function ($asignacion) {
                return $asignacion->tarea_lote->horas / ($asignacion->tarea_lote->users->count());
            });

            $ingreso->asignaciones = $asignaciones;
            $ingreso->horas_totales = $horas_totales;

            return $ingreso;
        });

        $this->asignados = $this->tarealote->users; 
        $asignadosIds = $this->asignados->pluck('usuario_id')->toArray();
        $this->ingresos = $this->ingresos->filter(function($ingreso) use ($asignadosIds) {
            return !in_array($ingreso->emp_id, $asignadosIds);
        });


    }

    public function cerrarAsignacion()
    {
        if($this->tarealote->users->count() < $this->cuposMinimos){
            $this->dispatch ('mostrarAlertaCierre', [
                'cuposMinimos' => $this->cuposMinimos,
            ]);
            return;
        }

        AsignacionDiaria::create([
            'tarea_lote_id' => $this->tarealote->id
        ]);

        return redirect()->route('planSemanal.tareasLote',[$this->lote,$this->plansemanalfinca])->with('success','Asignación Creada Correctamente');
    }

    public function cerrarAsignacionForzada()
    {
    AsignacionDiaria::create([
        'tarea_lote_id' => $this->tarealote->id
    ]);

    return redirect()->route('planSemanal.tareasLote', [$this->lote, $this->plansemanalfinca])
                     ->with('success', 'Asignación Creada Correctamente a pesar de los cupos mínimos.');
    }

    public function AsignarDron()
    {
        try {
            AsignacionTareaLoteDron::create([
                'tarea_lote_id' => $this->tarealote->id
            ]);
            
            AsignacionDiaria::create([
                'tarea_lote_id' => $this->tarealote->id,
                'use_dron' => 1
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('planSemanal.tareasLote', [$this->lote, $this->plansemanalfinca])
                     ->with('error', 'Existe un error al crear la asignación, intentelo de nuevo más tarde');
        }
        

        return redirect()->route('planSemanal.tareasLote', [$this->lote, $this->plansemanalfinca])
                     ->with('success', 'Asignación Creada Correctamente');
    }
    
    public function render()
    {
        return view('livewire.asignar-empleados-tarea');
    }
}
