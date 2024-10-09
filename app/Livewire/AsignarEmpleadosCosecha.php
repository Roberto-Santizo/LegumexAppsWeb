<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmpleadoFinca;
use App\Models\UsuarioTareaCosecha;

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
    protected $listeners = ['AsignarEmpleado','DesasignarEmpleado'];


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

    private function actualizarIngresos()
    {
        $this->asignados = $this->tarealotecosecha->users; 
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
