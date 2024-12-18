<?php

namespace App\Livewire;

use App\Models\OrdenTrabajo;
use Livewire\Component;

class MostrarOrdenesTrabajo extends Component
{
    public $ordenes;
    public $estado;
    public $labelEstado;
    public $open = false;
    public $otSelected;

    protected $listeners = ['closeModal','eliminarOT','takeTrabajo'];

    public function mount()
    {
        $labelsEstados = [
            1 => 'bg-yellow-500',
            2 => 'bg-orange-500',
            3 => 'bg-green-500',
            4 => 'bg-red-500'

        ];
        $this->labelEstado = $labelsEstados[$this->estado->id];
        $this->mostrarDatos();
    }

    public function mostrarDatos()
    {
        $this->ordenes = OrdenTrabajo::where('estado_id',$this->estado->id)->get();
    }

    public function asignarMecanicoModal(OrdenTrabajo $ot)
    {
        $this->open = true;
        $this->otSelected = $ot;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function desasignarMecanico(OrdenTrabajo $ot)
    {
        $ot->mecanico_id = null;
        $ot->fecha_asignacion = null;

        $ot->save();
        $this->mostrarDatos();
    }

    public function eliminarOT(OrdenTrabajo $ot)
    {
        $ot->delete();
        $this->mostrarDatos();
    }

    public function takeTrabajo(OrdenTrabajo $ot)
    {
        $ot->mecanico_id = auth()->user()->id;
        $ot->fecha_asignacion = now();
        $ot->save();

        $this->mostrarDatos();

    }
    public function render()
    {
        return view('livewire.mostrar-ordenes-trabajo');
    }
}
