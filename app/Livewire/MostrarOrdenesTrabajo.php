<?php

namespace App\Livewire;

use App\Models\OrdenTrabajo;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MostrarOrdenesTrabajo extends Component
{
    use WithPagination;

    public $estado;
    public $labelEstado;
    public $open = false;
    public $openFilters = false;
    public $otSelected;
    public $nombre_solicitante;
    public $planta;
    public $area;
    public $codigo;
    public $mecanico;

    protected $listeners = ['closeModal', 'eliminarOT', 'takeTrabajo'];

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        $labelsEstados = [
            1 => 'bg-yellow-500',
            2 => 'bg-orange-500',
            3 => 'bg-green-500',
            4 => 'bg-red-500'
        ];
        $this->labelEstado = $labelsEstados[$this->estado->id];
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
        $this->resetPage();
    }

    public function eliminarOT(OrdenTrabajo $ot)
    {
        $ot->delete();
        $this->resetPage();
    }

    public function takeTrabajo(OrdenTrabajo $ot)
    {
        $ot->mecanico_id = auth()->user()->id;
        $ot->fecha_asignacion = now();
        $ot->save();

        $this->resetPage();
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
        $this->nombre_solicitante = '';
        $this->planta = '';
        $this->area = '';
        $this->codigo = '';
        $this->mecanico = '';
        $this->resetPage();
        $this->openModalFilters();
    }

    public function render()
    {
        $query = OrdenTrabajo::query();

        if ($this->nombre_solicitante != '') {
            $query->where('nombre_solicitante', 'like', '%' . $this->nombre_solicitante . '%');
        }

        if ($this->planta != '') {
            $query->where('planta_id', 'LIKE', '%' . $this->planta . '%');
        }
        if ($this->codigo != '') {
            $query->where('correlativo', 'LIKE', '%'.$this->codigo.'%');
        }

        if ($this->mecanico != '') {
            $query->whereHas('mecanico', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->mecanico . '%');
            });
        }

        if ($this->area != '') {
            $query->whereHas('area', function ($q) {
                $q->where('area', 'LIKE', '%' . $this->area . '%');
            });
        }

        $query->where('estado_id', $this->estado->id)->orderBy('id', 'DESC');

        $ordenes = $query->paginate(10);

        return view('livewire.mostrar-ordenes-trabajo', [
            'ordenes' => $ordenes
        ]);
    }
}
