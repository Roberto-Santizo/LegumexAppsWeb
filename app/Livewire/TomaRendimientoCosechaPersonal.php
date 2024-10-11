<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\UsuarioTareaCosecha;
use App\Models\AsignacionDiariaCosecha;
use App\Models\CierreTareaLoteCosecha;

class TomaRendimientoCosechaPersonal extends Component
{
    public $asignaciones; 
    public $lote;
    public $plansemanalfinca;
    public $tarealotecosecha;
    public $hoy;

    public $registro = [];

    protected $listeners = ['cerrarAsignacion'];


    public function mount()
    {
        $this->hoy = Carbon::today();
        $this->actualizarAsignaciones();
    }
    public function registrarDato($asignacionId)
    {
        $dato = $this->registro[$asignacionId] ?? ''; // Obtiene el valor registrado
        $asignacion = UsuarioTareaCosecha::find($asignacionId);

        $asignacion->libras_asignacion = $dato;
        $asignacion->save();
        $this->actualizarAsignaciones();
    }

    private function actualizarAsignaciones()
    {
        $this->asignaciones = $this->tarealotecosecha->users()->whereDate('created_at',$this->hoy)->get();
    }

    public function cerrarAsignacion()
    {
        $asignacionesConCeroLibras = $this->asignaciones->filter(function($asignacion){
            return $asignacion->libras_asignacion == 0;
        });

        if($asignacionesConCeroLibras->isNotEmpty()){
            $this->addError('error', 'Registre las libras de todos los usuarios');
            return;
        }
        CierreTareaLoteCosecha::create([
            'tarea_lote_cosecha_id' => $this->tarealotecosecha->id,
            'terminado' => 1,
            'tipo_cierre' => 0
        ]);

        return redirect()->route('planSemanal.tareasCosechaLote',[$this->lote, $this->plansemanalfinca])->with('success','Asignación cerrada correctamente');
    }
 

    public function render()
    {
        return view('livewire.toma-rendimiento-cosecha-personal');
    }
}
