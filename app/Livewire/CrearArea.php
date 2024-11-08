<?php

namespace App\Livewire;

use App\Models\Planta;
use Livewire\Component;

class CrearArea extends Component
{
    public $plantas;
    public $ubicaciones = [];
    public $open = false;

    protected $listeners = ['closeModal','guardarUbicacion'];

    public function mount()
    {
        $this->plantas = Planta::all();
    }

    public function guardarUbicacion($datos)
    {
        dd($datos);
    }

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }
    public function render()
    {
        return view('livewire.crear-area');
    }
}
