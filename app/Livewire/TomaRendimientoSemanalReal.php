<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TomaRendimientoSemanalReal extends Component
{
    public $lote;
    public $plansemanalfinca;
    public $tarealotecosecha;
    public $asignaciones;
    public $sumaLibrasFinca;
    public $sumaPorFecha;
    public $plantas_cosechadas;
    
    public function mount()
    {
        // Agrupar las asignaciones por código
        $this->asignaciones = $this->tarealotecosecha->users()->orderBy('codigo')->get();

        $this->sumaLibrasFinca = $this->asignaciones->sum('libras_asignacion');

        $this->sumaPorFecha = $this->tarealotecosecha->users()
            ->select(DB::raw('DATE(created_at) as fecha'), DB::raw('SUM(libras_asignacion) as total_libras'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        $this->sumaPorFecha = $this->sumaPorFecha->map(function($fecha){
            $fecha->fecha = Carbon::parse($fecha->fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
            return $fecha;
        });

        $this->plantas_cosechadas = $this->tarealotecosecha->cierres()->orderBy('created_at','DESC')->first()->plantas_cosechadas;

    }
    public function render()
    {
        return view('livewire.toma-rendimiento-semanal-real');
    }
}
