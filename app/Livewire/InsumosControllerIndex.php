<?php

namespace App\Livewire;

use App\Models\Insumo;
use Livewire\Component;

class InsumosControllerIndex extends Component
{
    public $insumos;

    public function mount()
    {
        $this->insumos = Insumo::all();
    }

    public function render()
    {
        return view('livewire.insumos-controller-index');
    }
}
