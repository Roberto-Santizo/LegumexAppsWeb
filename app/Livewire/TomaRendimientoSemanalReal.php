<?php

namespace App\Livewire;

use Livewire\Component;

class TomaRendimientoSemanalReal extends Component
{
    public $lote;
    public $plansemanalfinca;
    public $tarealotecosecha;
    public $asignaciones;
    public $sumaLibrasFinca;
    public $resumenPorEmpleado;
    
    public function mount()
    {
        // Agrupar las asignaciones por código
        $this->asignaciones = $this->tarealotecosecha->users;

    }
    public function render()
    {
        return view('livewire.toma-rendimiento-semanal-real');
    }
}
