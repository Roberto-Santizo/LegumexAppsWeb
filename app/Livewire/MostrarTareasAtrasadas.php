<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class MostrarTareasAtrasadas extends Component
{

    public $plansemanalfinca;
    public $tareas;
    public $tareasFiltradas;

    public function mount()
    {
        $semanaplan = $this->plansemanalfinca->semana;
        $this->tareas = $this->plansemanalfinca->tareasTotales;

        $this->tareasFiltradas = $this->tareas->filter(function($tarea) use ($semanaplan) {
            if(!$tarea->cierre){
                return $tarea;
            }
        });
        // $this->tareasFiltradas = $tareas->filter(function ($tarea) use ($semanaplan) {
        //     if ($semanaplan < Carbon::now()->weekOfYear) {
        //         if (!$tarea->cierre) {
        //             if($tarea->movimientos->count() > 0){
        //                 $tarea->semana_origen = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->semana;
        //                 $tarea->finca = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->finca->finca;
        //             }
        //             return $tarea;
        //         }
        //     }
        // });
    }
    public function render()
    {
        return view('livewire.mostrar-tareas-atrasadas');
    }
}
