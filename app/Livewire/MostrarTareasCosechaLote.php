<?php

namespace App\Livewire;

use App\Models\CierreTareaLoteCosecha;
use App\Models\CierreTareaLoteCosechaSemanal;
use Livewire\Component;
use App\Models\TareaLoteCosecha;
use Carbon\Carbon;

class MostrarTareasCosechaLote extends Component
{
    public $tarea;
    public $plansemanalfinca;
    public $lote;
    public $successTareaLoteId;
    public $semanaActual; 
    public $asignaciones;
    public $successMessage;
    public $asignacionSinCierre;
    public $asignacionSinLibras;
    
    protected $listeners = ['eliminarTarea','terminarTarea'];


    public function mount()
    {
        $this->asignaciones = $this->tarea->asignaciones;

        $this->asignacionSinCierre = $this->asignaciones->contains(function($asignacion) {
            return !$asignacion->cierre;
        });

        $this->asignacionSinLibras = $this->asignaciones->contains(function($asignacion) {
            return $asignacion->cierre && !$asignacion->cierre->libras_total_planta;
        });

    }

    
    public function terminarTarea(TareaLoteCosecha $tarea)
    {
        $cierre = CierreTareaLoteCosechaSemanal::create([
            'tarea_lote_cosecha_id' => $tarea->id,
        ]);

        $this->successTareaLoteId = $tarea->id;
        $this->successMessage = 'La tarea fue terminada en fecha: ' . $cierre->created_at->format('d-m-Y h:i:s A');
    }

    public function eliminarTarea(TareaLoteCosecha $tarea)
    {
        $tarea->users()->delete();
        $tarea->asignaciones()->delete();
        $tarea->cierres()->delete();
        $tarea->delete();

        return redirect()->route('planSemanal.show',$this->plansemanalfinca)->with('success','Tarea eliminada correctamente');
    }
    
    public function render()
    {
        return view('livewire.mostrar-tareas-cosecha-lote');
    }
}
