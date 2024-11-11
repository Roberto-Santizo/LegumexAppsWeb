<?php

namespace App\Livewire;

use Livewire\Component;

class ModalElementoForm extends Component
{

    public $open;
    public $ubicacion;

    protected $rules = [
        'ubicacion' => 'required'
    ];

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function guardar()
    {
        $datos = $this->validate();
        $this->dispatch('guardarUbicacion',$datos);
    }

    public function render()
    {
        return view('livewire.modal-elemento-form');
    }
}
