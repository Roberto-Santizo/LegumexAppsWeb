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
    public $cierres;


    protected $listeners = ['actualizarFecha'];

    public function mount()
    {
        $this->plansemanalfinca = $this->tarealotecosecha->plansemanal;
        $this->asignacionesUsuariosFiltros = $this->tarealotecosecha->users()->orderBy('codigo','DESC')->get();
        $this->cierres = $this->tarealotecosecha->cierres;
        $this->lote = $this->tarealotecosecha->lote;
        $this->mostrarDatos();
    }

    public function mostrarDatos()
    {
        $this->asignaciones = $this->tarealotecosecha->asignaciones->filter(function($asignacion){
            if($asignacion->cierre)
            {
                $asignacion->fechaCosecha = $asignacion->created_at->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
                $asignacion->fechaInicio = $asignacion->created_at->format('h:i:s A');
                $asignacion->fechaFinal = $asignacion->cierre->created_at->format('h:i:s A');
                $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal),3);
                $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
                $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;
    
                $asignacion->peso_cabeza = round(($asignacion->totalCosechadoPlanta / $asignacion->cierre->plantas_cosechadas),2);
                return $asignacion;
            }
                
        });

        $this->asignacionesUsuarios = $this->asignacionesUsuariosFiltros->map(function($asignacionUsuario) {
            $asignacion = $this->asignaciones->filter(function($asignacionDiaria) use ($asignacionUsuario){
                if ($asignacionDiaria->created_at->toDateString() === $asignacionUsuario->created_at->toDateString()) {
                    $asignacionDiaria->totalPersonas = $asignacionDiaria->tareaLoteCosecha->users()->whereDate('created_at',$asignacionDiaria->created_at)->count();
                    return $asignacionDiaria;
                }
            });

            if($asignacion->isNotEmpty() && $asignacion->first()->totalCosechadoPlanta)
            {
                $asignacionUsuario->cosechadoPlanta = $asignacion->first()->totalCosechadoPlanta;
                $asignacionUsuario->cosechadoFinca = $asignacion->first()->totalCosechadoFinca;
                $asignacionUsuario->porcentaje = ($asignacionUsuario->libras_asignacion/ $asignacionUsuario->cosechadoFinca);
                $asignacionUsuario->cabezas_cosechadas = ($asignacionUsuario->porcentaje*$asignacion->first()->totalCosechadoPlanta)/$asignacion->first()->peso_cabeza;
                $asignacionUsuario->total_horas = $asignacionUsuario->cabezas_cosechadas/120;
        
                return $asignacionUsuario;
            }

        });

        $this->asignacionesUsuarios = $this->asignacionesUsuarios->filter(function($asignacion){
            return !is_null($asignacion);
        });

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
