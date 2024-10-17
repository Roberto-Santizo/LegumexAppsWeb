<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TomaRendimientoDiarioRealBrocoli extends Component
{
    public $lote;
    public $plansemanalfinca;
    public $tarealotecosecha;
    public $asignaciones;
    public $asignacion;
    public $sumaLibrasFinca;
    public $sumaPorFecha;
    public $pesoLbCabeza;
    public $rendimientoTeoricoPorPersona;
    public $plantas_cosechadas;
    public $montoTotal;
    public $totalLibrasPlantaIngresado;
    public $totalLibrasFincaReportado;
    public $rendimiento; 

    protected $listeners = ['RegistrarLibras'];

    public function mount()
    {
        $this->rendimiento = $this->tarealotecosecha->tarea->cultivo->rendimiento;
        $this->asignacion = $this->tarealotecosecha->asignaciones->sortByDesc('created_at')->first();
        $this->totalLibrasFincaReportado = $this->asignacion->cierre->libras_total_finca;
        $this->sumaLibrasFinca = $this->asignacion->cierre->libras_total_finca;

        $this->calculoDatos();

    }

    public function updatedTotalLibrasPlantaIngresado($value)
    {
        if($value === ''){
            $this->totalLibrasFincaReportado = $this->asignacion->cierre->libras_total_finca;
        }else{
            $this->totalLibrasFincaReportado = (int) $value;
        }
        $this->calculoDatos();
    }

    public function calculoDatos()
    {

        $this->asignaciones = $this->tarealotecosecha->users()->whereDate('created_at',$this->asignacion->created_at)->orderBy('codigo')->get();
        
        $this->pesoLbCabeza = round(($this->totalLibrasFincaReportado / $this->asignacion->cierre->plantas_cosechadas),2);
        
        $this->rendimientoTeoricoPorPersona = round(($this->pesoLbCabeza * $this->rendimiento),2);

        $this->montoTotal = round(((($this->totalLibrasFincaReportado/ $this->rendimientoTeoricoPorPersona) * 8)*11.98),2);

        $this->asignaciones = $this->asignaciones->map(function($asignacion) {
            $asignacion->porcentaje = ($asignacion->libras_asignacion/ $this->sumaLibrasFinca ) * 100;
            $asignacion->monto_ganado = round((($asignacion->porcentaje/100) * $this->montoTotal),4);
            return $asignacion;
        });

        $this->sumaPorFecha = $this->tarealotecosecha->users()
            ->select(DB::raw('DATE(created_at) as fecha'), DB::raw('SUM(libras_asignacion) as total_libras'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->whereDate('created_at',$this->asignacion->created_at)
            ->get();


        $this->sumaPorFecha = $this->sumaPorFecha->map(function($fecha){
            $fecha->fecha = Carbon::parse($fecha->fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
            return $fecha;
        });

        $this->plantas_cosechadas = $this->tarealotecosecha->cierres()->orderBy('created_at','DESC')->first()->plantas_cosechadas;
    }

    public function RegistrarLibras()
    {
        $this->asignacion->cierre->libras_total_planta = $this->totalLibrasFincaReportado;

        $this->asignacion->cierre->save();

        return redirect()->route('planSemanal.tareasCosechaLote',[$this->lote,$this->plansemanalfinca])->with('success','Registro de libras Guardado Correctamente');
    }
    public function render()
    {
        return view('livewire.toma-rendimiento-diario-real-brocoli');
    }
}


