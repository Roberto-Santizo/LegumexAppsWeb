<?php

namespace App\Livewire;

use App\Models\InsumoTarea;
use App\Models\RendimientoDiario;
use Livewire\Component;

class ModalInsumos extends Component
{
    public $tarea;
    public $registro = [];

    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function registrarDato($insumoId)
    {
        if(!isset($this->registro[$insumoId]))
        {
            $this->addError('error', 'Debe colocar el dato correspondiente a la cantidad del insumo utilizada');
            return;
        }
        $dato = $this->registro[$insumoId] ?? ''; 
        $insumo = InsumoTarea::find($insumoId);

        try {
            $insumo->cantidad_usada = $dato;
            $insumo->save();
        } catch (\Throwable $th) {
            $this->addError('error', 'Existe un error al guardar, intentelo de nuevo');
            return;
        }

    }

    public function cerrarAsignacion()
    {
        $insumosSinCantidadUsada = $this->tarea->insumos->filter(function($insumo){
            return !$insumo->cantidad_usada;
        });

        if($insumosSinCantidadUsada->isNotEmpty()){
            $this->addError('error', 'Registre todos los insumos antes de cerrar la asignación');
            return;
        }

        try {
            $this->dispatch('terminarTarea',$this->tarea);
            $this->closeModal();
        } catch (\Throwable $th) {
            $this->addError('error', 'Existe un error al darle cierre a la asignación');
            return;
        }

    }

    public function render()
    {
        return view('livewire.modal-insumos');
    }
}
