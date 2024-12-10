<?php

namespace App\Livewire;

use App\Models\Insumo;
use Livewire\Component;

class AddInsumoModal extends Component
{   
    public $insumos;
    public $nombre_insumo;

    public function mount()
    {
        $this->insumos = Insumo::all();
    }

    public function buscarInsumo()
    {
        if ($this->nombre_insumo != '') {
            $this->insumos = Insumo::where('insumo', 'like', '%' . $this->nombre_insumo . '%')
                                   ->orderBy('insumo', 'asc')
                                   ->get();
        } else {
            $this->insumos = Insumo::all();
        }
    }

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function agregarInsumo(Insumo $insumo)
    {
        $this->dispatch('agregarInsumo',$insumo);
        $this->closeModal();
    }   
    public function render()
    {
        return view('livewire.add-insumo-modal');
    }
}
