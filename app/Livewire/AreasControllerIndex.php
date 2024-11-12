<?php

namespace App\Livewire;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;

class AreasControllerIndex extends Component
{
    public $isOpen;
    public $area = '';
    public $planta = 0;
    protected $listeners = ['mostrarDatos'];

    protected $rules = [
        'area' => 'nullable',
        'planta' => 'nullable'
    ];

    use WithPagination;

    public function updating($field)
    {
        if (in_array($field, ['area', 'planta'])) {
            $this->resetPage();
        }
    }

    public function openModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function formatearDatos()
    {
        $query = Area::query();

        if ($this->area != '') {
            $query->where('area', 'LIKE', '%' . $this->area . '%');
        }

        if ($this->planta != 0) {
            $query->where('planta_id', $this->planta);
        }

        return $query->orderBy('id', 'DESC')->paginate(10);
    }

    public function mostrarDatos()
    {
        $this->validate();
        $this->resetPage();
    }

    public function borrarFiltros()
    {
        $this->area = '';
        $this->planta = 0;
        $this->resetPage();
        $this->openModal();
    }

    public function render()
    {
        $areas = $this->formatearDatos();
        return view('livewire.areas-controller-index', compact('areas'));
    }
}
