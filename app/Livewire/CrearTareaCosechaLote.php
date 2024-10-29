<?php

namespace App\Livewire;

use App\Models\Lote;
use Livewire\Component;
use App\Models\TareaCosecha;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\TareaLoteCosecha;

class CrearTareaCosechaLote extends Component
{

    public $planes;
    public $lotes;
    public $semana;
    public $tareas;

    public $tarea_cosecha_id;
    public $plan_semanal_finca_id;
    public $lote_id;
    
    protected $rules = [
        'tarea_cosecha_id' => 'required',
        'plan_semanal_finca_id' => 'required',
        'lote_id' => 'required',
    ];

    public function mount()
    {
        $this->semana = Carbon::now()->weekOfYear;
        $this->planes = PlanSemanalFinca::where('semana','>=',$this->semana)->get();
        $this->lotes = Lote::all();
        $this->tareas = TareaCosecha::all();
    }

    public function crearTareaLoteCosecha()
    {
        $datos = $this->validate();

        try {
            $plan_semanal_finca = PlanSemanalFinca::find($datos['plan_semanal_finca_id']['value']);
            $lote = Lote::where('id', $datos['lote_id']['value'])->where('finca_id', $plan_semanal_finca->finca->id)->first();
            $tareaCosecha = TareaLoteCosecha::where('plan_semanal_finca_id',$plan_semanal_finca->id)->where('lote_id',$lote->id)->get()->first();
            if($tareaCosecha)
            {
                $this->addError('error','Ya existe una tarea de cosecha asignada al ' . $plan_semanal_finca->finca->finca . ' SEMANA ' . $plan_semanal_finca->semana . ' en el lote ' . $lote->nombre);
                return;
            }
            
            if(!$lote)
            {
                $this->addError('error','El lote seleccionado no coincide con la finca del plan seleccionado');
                return;
            }
    
            TareaLoteCosecha::create([
                'plan_semanal_finca_id' => $datos['plan_semanal_finca_id']['value'],
                'lote_id' => $lote->id,
                'tarea_cosecha_id' => $datos['tarea_cosecha_id']['value'],
            ]);
            return redirect()->route('planSemanal')->with('success','Tarea Cosecha creada Correctamente');
        } catch (\Throwable $th) {
            $this->addError('error','Existe un error al crear la tarea de cosecha semanal, intentelo de nuevo más tarde o comuniquese con su administrador');
        }
       

       
    }
    public function render()
    {
        return view('livewire.crear-tarea-cosecha-lote');
    }
}
