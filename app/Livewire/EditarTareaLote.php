<?php

namespace App\Livewire;

use App\Models\BitacoraTareaLote;
use App\Models\Lote;
use Livewire\Component;
use App\Models\TareasLote;
use App\Models\PlanSemanalFinca;

class EditarTareaLote extends Component
{
    public $id;
    public $personas;
    public $presupuesto;
    public $horas;
    public $plan_semanal_finca_id;
    public $lote_id;
    public $finca_id;

    protected $rules = [
        'personas' => 'required',
        'presupuesto' => 'required',
        'horas' => 'required',
        'plan_semanal_finca_id' => 'required',
        'lote_id' => 'required'
    ];


    public function mount(TareasLote $tareaslote){
        $this->id = $tareaslote->id;
        $this->personas = $tareaslote->personas;
        $this->presupuesto = $tareaslote->presupuesto;
        $this->horas = $tareaslote->horas;
        $this->plan_semanal_finca_id = $tareaslote->plan_semanal_finca_id;
        $this->lote_id = $tareaslote->lote_id;
        $this->finca_id = $tareaslote->plansemanal->finca->id;
    }
    public function render()
    {
        $planes = PlanSemanalFinca::where('finca_id',$this->finca_id)->get();
        return view('livewire.editar-tarea-lote',['planes' => $planes,'plan_semanal_finca_id' => $this->plan_semanal_finca_id]);
    }

    public function editarTarea(){
        $datos = $this->validate();
        $tarealote = TareasLote::find($this->id);

        BitacoraTareaLote::create([
            'plan_semanal_id_dest' => $datos['plan_semanal_finca_id'],
            'plan_semanal_id_org' => $tarealote->plan_semanal_finca_id,
            'tarea_lote_id' => $tarealote->id
        ]);
        
        $plansemanal = $tarealote->plansemanal;
        $lote = $tarealote->lote;

        $tarealote->personas = $datos['personas'];
        $tarealote->presupuesto = $datos['presupuesto'];
        $tarealote->horas = $datos['horas'];
        $tarealote->plan_semanal_finca_id = $datos['plan_semanal_finca_id'];
        $tarealote->lote_id = $datos['lote_id'];
        
        $tarealote->save();

        return redirect()->route('planSemanal.tareasLote',[$lote,$plansemanal])->with('success','Tarea Editada correctamente');
    }
}
