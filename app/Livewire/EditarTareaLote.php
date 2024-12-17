<?php

namespace App\Livewire;

use App\Models\BitacoraTareaLote;
use App\Models\Lote;
use Livewire\Component;
use App\Models\TareasLote;
use App\Models\PlanSemanalFinca;
use Carbon\Carbon;

class EditarTareaLote extends Component
{
    public $id;
    public $personas;
    public $presupuesto;
    public $horas;
    public $plan_semanal_finca_id;
    public $lote_id;
    public $finca_id;
    public $tarea;
    public $fechaAsignacion;
    public $horaAsignacion;
    public $fechaCierre;
    public $horaCierre;

    protected $rules = [
        'personas' => 'required',
        'presupuesto' => 'required',
        'horas' => 'required',
        'plan_semanal_finca_id' => 'required',
        'lote_id' => 'required',
    ];


    public function mount(TareasLote $tareaslote){
        $this->tarea = $tareaslote;
        $this->id = $tareaslote->id;
        $this->personas = $tareaslote->personas;
        $this->presupuesto = $tareaslote->presupuesto;
        $this->horas = $tareaslote->horas;
        $this->plan_semanal_finca_id = $tareaslote->plan_semanal_finca_id;
        $this->lote_id = $tareaslote->lote_id;
        $this->finca_id = $tareaslote->plansemanal->finca->id;
        $this->fechaAsignacion = $tareaslote->asignacion ? $tareaslote->asignacion->created_at->format('Y-m-d') : null;
        $this->horaAsignacion = $tareaslote->asignacion ? $tareaslote->asignacion->created_at->format('h:m') : null;
        $this->fechaCierre = $tareaslote->cierre ? $tareaslote->cierre->created_at->format('Y-m-d') : null;
        $this->horaCierre = $tareaslote->cierre ? $tareaslote->cierre->created_at->format('h:m') : null;
    }

    public function editarTarea(){
        $datos = $this->validate();

        if($this->tarea->asignacion)
        {
            $fechaAsignacion = $this->fechaAsignacion . ' ' . $this->horaAsignacion;
            $fechaAsignacionCarbon = Carbon::parse($fechaAsignacion);
            $this->tarea->asignacion->created_at = $fechaAsignacionCarbon;
            $this->tarea->asignacion->save();
        }

        if($this->tarea->cierre)
        {
            $fechaCierre = $this->fechaCierre . ' ' . $this->horaCierre;
            $fechaCierreCarbon = Carbon::parse($fechaCierre);
            $this->tarea->cierre->created_at = $fechaCierreCarbon;
            $this->tarea->cierre->save();
        }

        if($datos['plan_semanal_finca_id'] != $this->tarea->plan_semanal_finca_id)
        {
            BitacoraTareaLote::create([
                'plan_semanal_id_dest' => $datos['plan_semanal_finca_id'],
                'plan_semanal_id_org' => $this->tarea->plan_semanal_finca_id,
                'tarea_lote_id' => $this->tarea->id
            ]);
        }
        
        $plansemanal = $this->tarea->plansemanal;
        $lote = $this->tarea->lote;

        $this->tarea->personas = $datos['personas'];
        $this->tarea->cupos = $datos['personas'];
        $this->tarea->presupuesto = $datos['presupuesto'];
        $this->tarea->horas = $datos['horas'];
        $this->tarea->plan_semanal_finca_id = $datos['plan_semanal_finca_id'];
        $this->tarea->lote_id = $datos['lote_id'];
        
        
        $this->tarea->save();

        return redirect()->route('planSemanal.tareasLote',[$lote,$plansemanal])->with('success','Tarea Editada correctamente');
    }

    public function render()
    {
        $planes = PlanSemanalFinca::where('finca_id',$this->finca_id)->get();
        return view('livewire.editar-tarea-lote',['planes' => $planes,'plan_semanal_finca_id' => $this->plan_semanal_finca_id]);
    }
}
