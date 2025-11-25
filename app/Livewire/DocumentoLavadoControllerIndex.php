<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Documentold;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;

class DocumentoLavadoControllerIndex extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $tecnico = '';
    public $area = '';
    public $planta = 0;
    public $fecha = null;
    public $year = 0;
    public $month = null;

    protected $listeners = ['eliminarDocumento'];

    protected $rules = [
        'tecnico' => 'nullable',
        'area' => 'nullable',
        'planta' => 'nullable',
        'fecha' => 'nullable'
    ];

    // Resetea la paginación al aplicar o borrar filtros
    public function updating($field)
    {
        if (in_array($field, ['tecnico', 'area', 'planta', 'fecha'])) {
            $this->resetPage();
        }
    }

    public function formatearDatos()
    {
        $query = Documentold::query();

        if ($this->tecnico != '') {
            $query->where('tecnico_mantenimiento', 'LIKE', '%' . $this->tecnico . '%');
        }

        if ($this->area != '') {
            $query->whereHas('area', function ($q) {
                $q->where('area', 'LIKE', '%' . $this->area . '%');
            });
        }

        if ($this->planta != 0) {
            $query->where('planta_id', $this->planta);
        }

        if ($this->fecha != null) {
            $this->fecha = Carbon::parse($this->fecha);
            $query->where('fecha', $this->fecha->format('d-m-Y'));
        }

        if ($this->month) {
            $query->whereMonth('created_at', $this->month);
        }

        if ($this->year != 0) {
            $query->whereYear('created_at', $this->year);;
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
        $this->tecnico = '';
        $this->area = '';
        $this->fecha = null;
        $this->planta = 0;
        $this->year = 0;
        $this->month = null;
        $this->resetPage();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function eliminarDocumento(Documentold $documento)
    {
        $documento->herramientas()->delete();
        $documento->delete();
        $this->mostrarDatos();
    }

    public function render()
    {
        $usuario = auth()->user();

        if ($usuario->getRoleNames()->first() === 'auxmanto') {
            $documentos = Documentold::where('tecnico_mantenimiento', $usuario->name)
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $documentos = $this->formatearDatos();
        }

        return view('livewire.documento-lavado-controller-index', compact('documentos'));
    }
}
