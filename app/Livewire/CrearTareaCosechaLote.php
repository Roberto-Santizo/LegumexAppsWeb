<?php

namespace App\Livewire;

use App\Models\TareaLoteCosecha;
use Livewire\Component;

class CrearTareaCosechaLote extends Component
{

    public $planes;
    public $lotes;
    public $tareas;

    public $tarea_cosecha_id;
    public $plan_semanal_finca_id;
    public $lote_id;
    
    protected $rules = [
        'tarea_cosecha_id' => 'required',
        'plan_semanal_finca_id' => 'required',
        'lote_id' => 'required',
    ];

    public function crearTareaLoteCosecha()
    {
        $datos = $this->validate();

        TareaLoteCosecha::create([
            'plan_semanal_finca_id' => $datos['plan_semanal_finca_id']['value'],
            'lote_id' => $datos['lote_id']['value'],
            'tarea_cosecha_id' => $datos['tarea_cosecha_id']['value'],
        ]);

        return redirect()->route('planSemanal')->with('success','Tarea creada Correctamente');
    }
    public function render()
    {
        return view('livewire.crear-tarea-cosecha-lote');
    }
}
