<?php

namespace App\Livewire;

use Livewire\Component;

class MostrarOrdenesTrabajo extends Component
{
    public $ordenes;
    public $estado;
    public $labelEstado;

    public function mount()
    {
        $labelsEstados = [
            1 => 'bg-yellow-500',
            2 => 'bg-orange-500',
            3 => 'bg-green-500',
            4 => 'bg-red-500'

        ];
        $this->labelEstado = $labelsEstados[$this->estado->id];
    }
    public function render()
    {
        return view('livewire.mostrar-ordenes-trabajo');
    }
}
