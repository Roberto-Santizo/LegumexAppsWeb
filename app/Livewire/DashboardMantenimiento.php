<?php

namespace App\Livewire;

use App\Models\OrdenTrabajo;
use Livewire\Component;

class DashboardMantenimiento extends Component
{
    public $ordenesPendientes;

    public function mount()
    {
        $this->ordenesPendientes = OrdenTrabajo::where('estado_id',1)->where('mecanico_id',null)->with('estado')->get();
    }
    public function render()
    {
        return view('livewire.dashboard-mantenimiento');
    }
}
