<?php

namespace App\Livewire;

use App\Models\Finca;
use App\Models\Lote;
use App\Models\PlanSemanalFinca;
use App\Models\TareasLote;
use Livewire\Component;

class ConsultarHistoricoLote extends Component
{
    public $lotes = [];
    public $lote_id = null;
    public $selected_lote;
    public $periodo = null;
    public $periodos;
    public $tareas = [];
    public $fincas;
    public $finca_id;

    public function mount()
    {
        $this->periodos = PlanSemanalFinca::all()->pluck('year')->unique();
        $this->fincas = Finca::all();
    }
    public function render()
    {
        return view('livewire.consultar-historico-lote');
    }

    public function fetchLotes()
    {
        $this->lotes = Lote::where('finca_id',$this->finca_id)->get();
    }

    public function cargarDatos()
    {
        $this->tareas = [];
        $this->selected_lote = Lote::find($this->lote_id);

        $tareas = TareasLote::where('lote_id', $this->lote_id)
            ->whereHas('plansemanal', function ($query) {
                $query->where('year', $this->periodo);
            })
            ->with('plansemanal') 
            ->get()
            ->groupBy(function ($tarea) {
                return $tarea->plansemanal->semana; 
            });

            foreach ($tareas as $semana => $tareas) {
                foreach ($tareas as $tarea) {
                    $this->tareas[$semana][] = $tarea;
                }
            }
    }
}
