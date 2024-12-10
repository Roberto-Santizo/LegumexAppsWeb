<?php

namespace App\Livewire;

use App\Models\Insumo;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class InsumosControllerIndex extends Component
{

    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        $insumos = Insumo::paginate(10);
        return view('livewire.insumos-controller-index',['insumos' => $insumos]);
    }
}
