<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\TrabajoEquipo;
use Livewire\Component;

class CrearTrabajoEquipo extends Component
{
    public $descripcion;
    public $fecha_planificacion;
    public $equipo;
    
    protected $rules = [
        'descripcion' => 'required',
        'fecha_planificacion' => 'required'
    ];

    public function mount(Equipo $equipo)
    {
        $this->equipo = $equipo;
    }
    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function createTrabajo()
    {
        $data = $this->validate();

        TrabajoEquipo::create([
            'descripcion' => $data['descripcion'],
            'fecha_planificacion' => $data['fecha_planificacion'],
            'equipo_id' => $this->equipo->id
        ]);

        $this->dispatch('closeModal');
    }
    
    public function render()
    {
        return view('livewire.crear-trabajo-equipo');
    }
}
