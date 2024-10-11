<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\TareasLote;
use App\Models\RendimientoDiario;

class MostrarTareasLote extends Component
{
    protected $listeners = ['eliminarTarea','terminarTarea'];

    public $tareas;
    public $plansemanalfinca;
    public $atrasadas;
    public $lote;
    public $semanaActual;
    public $successMessage;
    public $successTareaLoteId;

    public function eliminarTarea(TareasLote $tarea)
    {
        $tarea->users()->delete();
        $tarea->asignacion()->delete();
        $tarea->cierre()->delete();
        $tarea->movimientos()->delete();
        $tarea->delete();

    }

    public function terminarTarea(TareasLote $tarea)
    {
        $cierre = RendimientoDiario::create([
            'tarea_lote_id' => $tarea->id,
            'terminado' => 1
        ]);

        $this->successTareaLoteId = $tarea->id;
        $this->successMessage = 'La tarea fue terminada en fecha: ' . $cierre->created_at->format('d-m-Y h:i:s A');
    }

    public function render()
    {   
        $this->semanaActual = Carbon::now()->weekOfYear();
        return view('livewire.mostrar-tareas-lote');
    }

   
}
