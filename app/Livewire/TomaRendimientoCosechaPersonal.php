<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\UsuarioTareaCosecha;
use App\Models\CierreTareaLoteCosecha;

class TomaRendimientoCosechaPersonal extends Component
{
    public $asignaciones; 
    public $lote;
    public $plansemanalfinca;
    public $tarealotecosecha;
    public $hoy;
    public $plantas_cosechadas;

    public $registro = [];

    protected $rules = [
        'plantas_cosechadas' => 'required'
    ];
    protected $listeners = ['cerrarAsignacion'];


    public function mount()
    {
        $this->hoy = Carbon::today();
        $this->actualizarAsignaciones();
    }
    public function registrarDato($asignacionId)
    {
        if(!isset($this->registro[$asignacionId]))
        {
            $this->addError('error', 'Debe colocar el dato correspondiente de las libras cosechadas');
            return;
        }
        $dato = $this->registro[$asignacionId] ?? ''; // Obtiene el valor registrado
        $asignacion = UsuarioTareaCosecha::find($asignacionId);

        try {
            $asignacion->libras_asignacion = $dato;
            $asignacion->save();
        } catch (\Throwable $th) {
            $this->addError('error', 'Existe un error al guardar, intentelo de nuevo');
            return;
        }

        $this->actualizarAsignaciones();
    }

    private function actualizarAsignaciones()
    {
        $this->asignaciones = $this->tarealotecosecha->users()->whereDate('created_at',$this->hoy)->get();
    }

    public function cerrarAsignacion()
    {
        $this->validate();
        $asignacionesConCeroLibras = $this->asignaciones->filter(function($asignacion){
            return $asignacion->libras_asignacion == 0;
        });

        if($asignacionesConCeroLibras->isNotEmpty()){
            $this->addError('error', 'Registre las libras de todos los usuarios');
            return;
        }

        $totalLibrasPorAsignacionDiaria = $this->tarealotecosecha->users()->whereDate('created_at',Carbon::today())->get()->sum('libras_asignacion');
        $ultimaAsignacionSinCierre= $this->tarealotecosecha->asignaciones->sortByDesc('created_at')->first();


        try {
            CierreTareaLoteCosecha::create([
                'tarea_lote_cosecha_id' => $this->tarealotecosecha->id,
                'terminado' => 1,
                'tipo_cierre' => 0,
                'plantas_cosechadas' => $this->plantas_cosechadas,
                'libras_total_finca' => $totalLibrasPorAsignacionDiaria,
                'asignacion_diaria_cosechas_id' => $ultimaAsignacionSinCierre->id
            ]);
        } catch (\Throwable $th) {
            $this->addError('error', 'Existe un error al darle cierre a la asignación');
            return;
        }
       

        return redirect()->route('planSemanal.tareasCosechaLote',[$this->lote, $this->plansemanalfinca])->with('success','Asignación cerrada correctamente');
    }
 

    public function render()
    {
        return view('livewire.toma-rendimiento-cosecha-personal');
    }
}
