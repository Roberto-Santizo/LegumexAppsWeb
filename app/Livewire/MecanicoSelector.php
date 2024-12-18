<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\OrdenTrabajo;

class MecanicoSelector extends Component
{
    public $ot;
    public $usuarios;
    public $isOpen = false;
    public $nombre_usuario = '';
    
    public function mount()
    {
        $this->usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', 'auxmanto')->where('status', 1);
        })->get();
    }

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }


    public function asignarMecanico(User $mecanico)
    {
        $this->ot->mecanico_id = $mecanico->id;
        $this->ot->fecha_asignacion = now();
        $this->ot->save();

        $this->closeModal();
    }

    public function buscarUsuario()
    {
        if ($this->nombre_usuario != '') {
            $this->usuarios = User::whereHas('roles', function($query){
                $query->where('name','auxmanto')->where('status',1);
            })->where('name','like','%' . $this->nombre_usuario . '%')->get();
        } else {
            $this->usuarios = User::whereHas('roles', function ($query) {
                $query->where('name', 'auxmanto')->where('status', 1);
            })->get();
        }
    }

    public function render()
    {
        return view('livewire.mecanico-selector');
    }
}
