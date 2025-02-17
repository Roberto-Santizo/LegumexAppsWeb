<?php

namespace App\Livewire;

use App\Models\Equipo;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class EquiposControllerIndex extends Component
{
    public $openFilters = false;
    public $code;
    public $planta;
    
    use WithPagination, WithoutUrlPagination;

    public function changeStatus(Equipo $equipo)
    {
        $equipo->status = !$equipo->status;
        $equipo->save();
        $this->MostrarDatos();
    }

    public function openModalFilters()
    {
        $this->openFilters = !$this->openFilters;
    }

    public function buscarDatos()
    {
        $this->resetPage();
    }

    public function borrarFiltros()
    {
        $this->code = '';
        $this->planta = '';
        $this->openModalFilters();
    }

    public function render()
    {
        $query = Equipo::query();

        if ($this->code != '') {
            $query->where('code', 'like', '%' . $this->code . '%');
        }

        if ($this->planta != '') {
            $query->whereHas('area',function($query){
                $query->where('planta_id',$this->planta);
            });
        } 

        $query->orderBy('id','DESC');
        $equipos = $query->paginate(10);
        return view('livewire.equipos-controller-index',compact('equipos'));
    }
}
