<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Elemento;
use Termwind\Components\Element;

class AreasControllerShow extends Component
{
    public $area;
    public $isOpen = false;

    protected $listeners = ['closeModal','guardarUbicacion','eliminarUbicacion'];


    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
    
    public function guardarUbicacion($datos)
    {

        try {
            Elemento::create([
                'elemento' => $datos['ubicacion'],
                'area_id' => $this->area->id
            ]);
            $this->closeModal();
        } catch (\Throwable $th) {
            $this->closeModal();
            $this->addError('error','Ocurrio un error al agregar el elemento ' . $th->getMessage());
        }
       
    }

    public function eliminarUbicacion(Elemento $elemento)
    {
        $elemento->delete();
    }

    public function render()
    {  
        return view('livewire.areas-controller-show');
    }
}
