<?php

namespace App\Livewire;

use Livewire\Component;

class MostrarTareasCosechaLote extends Component
{
    public $tareas;
    public $plansemanalfinca;
    public $lote;
    public $semanaActual; 
    public function render()
    {
        return view('livewire.mostrar-tareas-cosecha-lote');
    }
}
