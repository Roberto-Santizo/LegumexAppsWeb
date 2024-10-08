<?php

namespace App\Livewire;

use App\Models\UsuarioTareaLote;
use Livewire\Component;

class MostrarUsuariosAsignados extends Component
{
    protected $listeners = ['eliminarAsignacion'];
    public $asignaciones;

    public function eliminarAsignacion(UsuarioTareaLote $asignacion)
    {
        $asignacion->delete();
    }
    public function render()
    {
        return view('livewire.mostrar-usuarios-asignados');
    }
}
