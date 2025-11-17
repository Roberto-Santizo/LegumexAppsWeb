<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Documentocp;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class DocumentoChecklistControllerIndex extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $planta = 0;
    public $month = 0;
    public $year = 0;
    public $fecha = null;

    protected $listeners = ['eliminarDocumento'];

    protected $rules = [
        'planta' => 'nullable',
        'fecha' => 'nullable'
    ];

    public function updating($field)
    {
        if (in_array($field, ['planta', 'fecha', 'month', 'year'])) {
            $this->resetPage();
        }
    }

    public function formatearDatos()
    {
        $query = Documentocp::query();

        if ($this->planta) {
            $query->where('planta_id', $this->planta);
        }

        if ($this->fecha) {
            $this->fecha = Carbon::parse($this->fecha);
            $query->where('fecha', $this->fecha->format('d-m-Y'));
        }

        if ($this->month) {
            $query->whereMonth('created_at', $this->month);
        }

        if ($this->year) {
            $query->whereYear('created_at', $this->year);
        }

        return $query->orderBy('id', 'DESC')->paginate(10);
    }

    public function mostrarDatos()
    {
        $this->validate();
        $this->resetPage();
    }

    public function borrarFiltros()
    {
        $this->fecha = null;
        $this->planta = 0;
        $this->month = 0;
        $this->year = 0;
        $this->resetPage();
        $this->openModal();
    }

    public function eliminarDocumento(Documentocp $documento)
    {
        try {
            foreach ($documento->areas as $area) {
                $area->elementos()->delete();
            }
            $documento->areas()->delete();

            $documento->ordenes()->delete();
            $documento->delete();

            $this->dispatch('documentoEliminado');
            $this->mostrarDatos();
        } catch (\Throwable $th) {
            $this->addError('error', 'Hubo un error al intentar eliminar el documento, intentelo de nuevo más tarde');
        }
    }

    public function openModal()
    {
        $this->isOpen = !$this->isOpen;
    }
    public function render()
    {
        $documentos = $this->formatearDatos();
        return view('livewire.documento-checklist-controller-index', compact(['documentos']));
    }
}
