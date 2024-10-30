<?php

namespace App\Livewire;

use App\Models\Finca;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PlanSemanalFinca;

class PlanSemanalFincasIndex extends Component
{

    public $finca = 10;
    public $semana = 0;
    public $fincas;
    public $semanas;

    protected $rules = [
        'finca' => 'required',
        'semana'=> 'required'
    ];

    use WithPagination;

    public function mount()
    {
        $this->fincas = Finca::all();
        $this->semanas = PlanSemanalFinca::all()->pluck('semana')->toArray();
    }
    public function formatearDatos()
    {
        $query = PlanSemanalFinca::query();
        if($this->finca != 10)
        {
            $query->where('finca_id', $this->finca);
        }
        
        if($this->semana != 0)
        {
            $query->where('semana', $this->semana);
        }

        $planes = $query->orderBy('semana', 'DESC')->paginate(10);
        
        $planes->map(function ($plan) {
            $tareasCierre = collect();
            $tareasExtraordinarias = collect();
            $tareasPresupuestadas = collect();
            $tareasCosechasTerminadas = collect();
            
            foreach ($plan->tareasTotales as $tarea) {
                if ($tarea->cierre) {
                    $tareasCierre->push($tarea);
                }

                if ($tarea->extraordinaria) {
                    $tareasExtraordinarias->push($tarea);
                } else {
                    $tareasPresupuestadas->push($tarea);
                }
            }

            foreach($plan->tareasCosechaTotales as $tarea){
                if($tarea->cierreSemanal){
                    $tareasCosechasTerminadas->push($tarea); 
                }
            }

            $plan->tareasRealizadas = $tareasCierre;
            $plan->tareasExtraordinarias = $tareasExtraordinarias;
            $plan->tareasPresupuestadas = $tareasPresupuestadas;
            $plan->tareasCosechasTerminadas = $tareasCosechasTerminadas;

            $plan->tareasExtraordinariasTerminadas = $tareasExtraordinarias->filter(function ($tarea) {
                return $tarea->cierre;
            });

            $plan->tareasPresupuestadasTerminadas = $tareasPresupuestadas->filter(function ($tarea) {
                return $tarea->cierre;
            });

            $plan->presupuesto_extraordinario = $tareasExtraordinarias->sum('presupuesto');
            $plan->presupuesto_extraordinario_gastado = $plan->tareasExtraordinariasTerminadas->sum('presupuesto');

            $plan->presupuesto_general = $tareasPresupuestadas->sum('presupuesto');
            $plan->presupuesto_general_gastado = $plan->tareasPresupuestadasTerminadas->sum('presupuesto');

            return $plan;
        });

        return $planes;
    }

    public function mostrarDatos()
    {
        $datos = $this->validate();
        $this->semana = $datos['semana'];
        $this->finca = $datos['finca'];
        $this->formatearDatos();
    }
    public function render()
    {
        $planes = $this->formatearDatos();
        return view('livewire.plan-semanal-fincas-index',compact('planes'));
    }
}
