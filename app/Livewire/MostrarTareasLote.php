<?php

namespace App\Livewire;

use App\Models\Lote;
use Livewire\Component;
use App\Models\TareasLote;
use Carbon\Carbon;

class MostrarTareasLote extends Component
{
    protected $listeners = ['eliminarTarea'];

    public $tareas;
    public $plansemanalfinca;
    public $atrasadas;
    public $lote;
    public $semanaActual;

    public function eliminarTarea(TareasLote $tarea)
    {
        $tarea->delete();

    }

    public function render()
    {   
        $this->semanaActual = Carbon::now()->weekOfYear();
        return view('livewire.mostrar-tareas-lote');
    }

   
}
