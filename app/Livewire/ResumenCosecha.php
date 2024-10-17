<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\AsignacionDiariaCosecha;

class ResumenCosecha extends Component
{
    public $tarealotecosecha;
    public $plansemanalfinca;
    public $lote;
    public $asignaciones;
    public $asignacionesUsuarios;
    public $asignacionesUsuariosFiltros;
    public $asignacionSelected = 0;
    public $fecha = null;
    public $totalLibras;


    protected $listeners = ['actualizarFecha'];

    public function mount()
    {
        $this->plansemanalfinca = $this->tarealotecosecha->plansemanal;
        $this->asignacionesUsuariosFiltros = $this->tarealotecosecha->users()->orderBy('codigo','DESC')->get();
        $this->lote = $this->tarealotecosecha->lote;
        $this->totalLibras = $this->tarealotecosecha->users->sum('libras_asignacion');
        $this->mostrarDatos();
    }

    public function mostrarDatos()
    {
        $this->asignaciones = $this->tarealotecosecha->asignaciones->map(function($asignacion){
            $asignacion->fechaCosecha = $asignacion->created_at->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
            $asignacion->fechaInicio = $asignacion->created_at->format('d-m-Y h:i:s A');
            $asignacion->fechaFinal = $asignacion->cierre->created_at->format('d-m-Y h:i:s A');
            $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal),3);
            $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
            $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;

            return $asignacion;
        });

        $this->asignacionesUsuarios = $this->asignacionesUsuariosFiltros;
    }

    public function actualizarFecha(AsignacionDiariaCosecha $asignacion)
    {
        if($asignacion->id === $this->asignacionSelected){
            $this->asignacionesUsuariosFiltros = $this->tarealotecosecha->users()->orderBy('codigo','DESC')->get();
            $this->asignacionSelected = 0;
        }else{
            $this->asignacionSelected = $asignacion->id;
            $this->asignacionesUsuariosFiltros = $this->tarealotecosecha->users()->whereDate('created_at',$asignacion->created_at)->get();
        }
        
        $this->mostrarDatos();
    }

    public function render()
    {
        return view('livewire.resumen-cosecha');
    }
}
