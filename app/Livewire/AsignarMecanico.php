<?php

namespace App\Livewire;

use Livewire\Component;

class AsignarMecanico extends Component
{
    public $ot;
    public $hasMecanic;

    public function mount($ot)
    {
        $this->hasMecanic = ($ot->mecanico_id) ? true : false;
    }

    public function tomarTrabajo()
    {
        $this->ot->mecanico_id = $this->hasMecanic ? null : auth()->user()->id;
        $this->ot->fecha_asignacion = now();
        $this->ot->save();
        $this->hasMecanic = !$this->hasMecanic;
    }
    public function render()
    {
        return view('livewire.asignar-mecanico');
    }
}
