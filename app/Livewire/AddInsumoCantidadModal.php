<?php

namespace App\Livewire;

use App\Models\Insumo;
use Livewire\Component;
use Illuminate\Support\Str;

class AddInsumoCantidadModal extends Component
{

    public $insumo;
    public $insumosAgregados = [];
    public $cantidad = 0;
    public $editing = false;

    protected $rules = [
        'cantidad' => 'required|numeric|min:1'
    ];

    public function mount()
    {
        $this->cantidad = $this->insumo['cantidad'] ?? 0;
    }
    public function closeModal()
    {
        $this->dispatch('closeModalCantidad');
    }

    public function handleSubmit()
    {
        if(!$this->editing)
        {
            $this->addInsumo();
        }else{
            $this->editInsumo();
        }

    }
    public function addInsumo()
    {
        $datos = $this->validate();
        try {
            $this->insumo['id_insumo'] = Str::uuid() . '';
            $this->insumo['cantidad'] = $datos['cantidad'];
            $this->dispatch('agregarInsumo',$this->insumo);
            $this->closeModal();
        } catch (\Throwable $th) {
           dd($th->getMessage());
        }
        
    }

    public function editInsumo()
    {
        $datos = $this->validate();
        $updatedInsumosAgregados = collect($this->insumosAgregados)->map(function($insumoAgg) use($datos){
            if($insumoAgg['id_insumo'] === $this->insumo['id_insumo']){
                $insumoAgg['cantidad'] = $datos['cantidad'];
            }
            return $insumoAgg;
        });
        
        $this->dispatch('editInsumos',$updatedInsumosAgregados);
        $this->closeModal();
    }
    
    public function render()
    {
        return view('livewire.add-insumo-cantidad-modal');
    }
}
