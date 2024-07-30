<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\OrdenTrabajo;

class MecanicoSelector extends Component
{
    public $ot;
    public $usuarios = [];
    public $isOpen = false;
    public $search = '';
    public $hasMecanic = 0;

    public function mount()
    {
        $this->usuarios = User::whereHas('roles', function($query) {
            $query->where('name', 'auxmanto'); 
        })->get();
        $this->hasMecanic = $this->ot->mecanico_id ? 1 : 0;
    }

    public function asignarMecanico($userId)
    {
        $this->ot->mecanico_id = $userId;
        $this->ot->fecha_asignacion = now();
        $this->ot->save();

        $this->hasMecanic = 1;
        $this->isOpen = !$this->isOpen;
    }

    public function desAsignarMecanico()
    {
        $this->ot->mecanico_id = null;
        $this->ot->fecha_asignacion = null;
        $this->ot->save();

        $this->hasMecanic = 0;   
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function updatedSearch()
    {
        $this->usuarios = User::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function render()
    {
        return view('livewire.mecanico-selector');
    }
}
