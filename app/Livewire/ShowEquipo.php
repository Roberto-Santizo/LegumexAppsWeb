<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\TrabajoEquipo;
use Carbon\Carbon;
use Livewire\Component;

class ShowEquipo extends Component
{
    public $equipo;
    public $open = false;

    protected $listeners = ['closeModal'];
    
    public function mount(Equipo $equipo)
    {
        $this->equipo = $equipo;
    }

    public function Actualizar()
    {
        $this->equipo->status = !$this->equipo->status;
        $this->equipo->save();
    }

    public function OpenModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function closeJob(TrabajoEquipo $trabajo)
    {
       $trabajo->status = 0;
       $trabajo->fecha_realizacion = Carbon::now();
       $trabajo->save();
    }
    public function render()
    {
        return view('livewire.show-equipo');
    }
}
