<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TareasLote;

class CrearTareaLote extends Component
{
    public $tareas;
    public $planes;
    public $lotes;

    public $personas;
    public $presupuesto;
    public $horas;
    public $tarea_id;
    public $plan_semanal_finca_id;
    public $lote_id;

    protected $rules = [
        'personas' => 'required',
        'presupuesto' => 'required',
        'horas' => 'required',
        'tarea_id' => 'required',
        'plan_semanal_finca_id' => 'required',
        'lote_id' => 'required',
    ];
    

    public function crearTareaLoteExt()
    {
       $datos = $this->validate();

       TareasLote::create([
            'plan_semanal_finca_id' => $datos['plan_semanal_finca_id']['value'],
            'lote_id' => $datos['lote_id']['value'],
            'plan' => $datos['tarea_id']['value'],
            'tarea_id' => $datos['tarea_id']['value'],
            'personas' => $datos['personas'],   
            'presupuesto' => $datos['presupuesto'],
            'horas' => $datos['horas'],
            'cupos' => $datos['personas'],
            'horas_persona' => ($datos['horas'])/$datos['personas'],
            'extraordinaria' => 1

        ]);

        return redirect()->route('planSemanal')->with('success','Tarea creada Correctamente');
    }
    public function render()
    {
        return view('livewire.crear-tarea-lote');
    }
}
