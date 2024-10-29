<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\Tarea;
use Livewire\Component;
use App\Models\TareasLote;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;

class CrearTareaLote extends Component
{
    public $tareas;
    public $planes;
    public $lotes;
    public $semana;
    
    public $personas;
    public $presupuesto;
    public $horas;
    public $tarea_id;
    public $plan_semanal_finca_id;
    public $lote_id;

    protected $rules = [
        'personas' => 'required|numeric|min:1',
        'presupuesto' => 'required|numeric|gt:0',
        'horas' => 'required|numeric|gt:0',
        'tarea_id' => 'required',
        'plan_semanal_finca_id' => 'required',
        'lote_id' => 'required',
    ];

    public function mount()
    {
        $this->semana = Carbon::now()->weekOfYear;
        $this->tareas = Tarea::all();
        $this->planes = PlanSemanalFinca::where('semana','>=',$this->semana)->get();
        $this->lotes = Lote::all();
    }


    public function crearTareaLoteExt()
    {
       $datos = $this->validate();

       try {
        $plan_semanal_finca = PlanSemanalFinca::find($datos['plan_semanal_finca_id']['value']);
        $lote = Lote::where('id', $datos['lote_id']['value'])->where('finca_id', $plan_semanal_finca->finca->id)->first();
        if(!$lote)
        {
            $this->addError('error','El lote seleccionado no coincide con la finca del plan seleccionado');
            return;
        }

        TareasLote::create([
                'plan_semanal_finca_id' => $datos['plan_semanal_finca_id']['value'],
                'lote_id' => $datos['lote_id']['value'],
                'plan' => $datos['tarea_id']['value'],
                'tarea_id' => $datos['tarea_id']['value'],
                'personas' => $datos['personas'],   
                'presupuesto' => $datos['presupuesto'],
                'horas' => $datos['horas'],
                'cupos' => $datos['personas'],
                'horas_persona' => $datos['personas'],
                'extraordinaria' => 1

            ]);
       } catch (\Throwable $th) {
            $this->addError('error','Existe un error al crear la tarea extraordinaria, intentelo de nuevo o comuniquese con el administrador');
       }
       

        return redirect()->route('planSemanal')->with('success','Tarea creada Correctamente');
    }
    public function render()
    {
        return view('livewire.crear-tarea-lote');
    }
}
