<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\PlanSemanalFinca;
use App\Models\TareasLote;
use Livewire\Component;

class ConsultarHistoricoLote extends Component
{
    public $lotes;
    public $lote_id;
    public $periodos;
    public $periodo;
    public $tareas = [];

    public function mount()
    {
        $this->lotes = Lote::all();
        $this->periodos = PlanSemanalFinca::all()->pluck('year');
    }
    public function render()
    {
        return view('livewire.consultar-historico-lote');
    }

    public function cargarDatos() 
    {
        $this->tareas = TareasLote::where('lote_id',$this->lote_id)->whereHas('plansemanal', function($query){
            $query->where('year',$this->periodo);
        })->get();
    }
}
