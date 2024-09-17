<?php

namespace App\Livewire;

use App\Models\Lote;
use Livewire\Component;
use App\Models\TareasLote;

class MostrarTareasLote extends Component
{
    protected $listeners = ['eliminarTarea'];

    public $tareas;
    public $plansemanalfinca;
    public $atrasadas;
    public $lote;

    public function eliminarTarea(TareasLote $tarea)
    {
        $tarea->delete();

    }

    public function render()
    {
        return view('livewire.mostrar-tareas-lote');
    }

   
}
