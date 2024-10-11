<?php

namespace App\Livewire;

use App\Models\CierreTareaLoteCosecha;
use Livewire\Component;
use App\Models\TareaLoteCosecha;
use Carbon\Carbon;

class MostrarTareasCosechaLote extends Component
{
    public $tareas;
    public $plansemanalfinca;
    public $lote;
    public $successTareaLoteId;
    public $semanaActual; 
    public $successMessage;

    protected $listeners = ['eliminarTarea','terminarTarea'];


    
    public function terminarTarea(TareaLoteCosecha $tarea)
    {
        $cierre = CierreTareaLoteCosecha::create([
            'tarea_lote_cosecha_id' => $tarea->id,
            'terminado' => 1,
            'tipo_cierre' => 1
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
        $this->successTareaLoteId = $tarea->id;
        $this->successMessage = 'La tarea fue eliminada';
    }
    
    public function render()
    {
        $hoy = Carbon::today();
        $this->tareas = $this->tareas->map(function($tarea) use ($hoy){
            $asignaciones = $tarea->asignaciones();
            $cierres = $tarea->cierres();
            $tarea->asignacionDiaria = false;
            $tarea->cierreDiario = false;
            $tarea->cierreSemanal = false;
            if($asignaciones->whereDate('created_at',$hoy)->exists()){
                $tarea->asignacionDiaria = true;
            }

            if($cierres->whereDate('created_at',$hoy)->exists()){
                $tarea->cierreDiario = true;
            }

            if($cierres->whereDate('created_at',$hoy)->where('tipo_cierre',1)->exists()){
                $tarea->cierreSemanal = true;
            }
            
            return $tarea;
        });

        return view('livewire.mostrar-tareas-cosecha-lote');
    }
}
