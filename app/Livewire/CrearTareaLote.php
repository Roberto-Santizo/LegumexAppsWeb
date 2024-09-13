<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TareasLote;

class CrearTareaLote extends Component
{
    public $lote;
    public $plansemanalfinca;
    public $tareas;

    public $personas;
    public $presupuesto;
    public $horas;
    public $tarea_id;

    protected $rules = [
        'personas' => 'required',
        'presupuesto' => 'required',
        'horas' => 'required',
        'tarea_id' => 'required',
    ];

    public function crearTareaLoteExt()
    {
       $datos = $this->validate();

       TareasLote::create([
            'plan_semanal_finca_id' => $this->plansemanalfinca->id,
            'lote_id' => $this->lote->id,
            'tarea_id' => $datos['tarea_id']['value'],
            'personas' => $datos['personas'],   
            'presupuesto' => $datos['presupuesto'],
            'horas' => $datos['horas'],
            'cupos' => $datos['personas'],
            'horas_persona' => ($datos['horas'])/$datos['personas'],
            'extraordinaria' => 1

        ]);

        return redirect()->route('planSemanal.tareasLote',[$this->lote,$this->plansemanalfinca])->with('success','Tarea creada Correctamente');
    }
    public function render()
    {
        return view('livewire.crear-tarea-lote');
    }
}
