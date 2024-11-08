<?php

namespace App\Livewire;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;

class AreasControllerIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $areas = Area::paginate(10);
        return view('livewire.areas-controller-index', compact('areas'));
    }
}
