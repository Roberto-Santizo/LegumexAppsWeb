<?php

namespace App\Livewire;

use App\Models\Tarea;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarTareasGenerales extends Component
{
    public $nombre_tarea = '';
    protected $rules = [
        'nombre_tarea' => 'required'
    ];
    use WithPagination;

    public function buscar()
    {
        $datos = $this->validate();
        $this->nombre_tarea = $datos['nombre_tarea'];
    }
    public function render()
    {
        if($this->nombre_tarea != '')
        {
            $tareas = Tarea::where('tarea', 'like', '%' . $this->nombre_tarea . '%')->paginate(10);

        }else{
            $tareas = Tarea::paginate(10);
        }
        
        return view('livewire.mostrar-tareas-generales',compact('tareas'));
    }
}
