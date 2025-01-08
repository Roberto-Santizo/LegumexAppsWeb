<?php

namespace App\Livewire;

use App\Models\InsumoTarea;
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
    public $searchTerm;
    public $insumos = [];
    public $open = false;
    public $openEditing = false;
    public $editingInsumo;
    public $year;

    public $tareasFiltradas;
    protected $listeners = ['closeModal','agregarInsumo','editInsumos','closeModalCantidad'];
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
        $this->year = Carbon::now()->year;
        $this->tareas = Tarea::all();
        $this->planes = PlanSemanalFinca::where('semana','>=',$this->semana)->where('year','>=',$this->year)->get();
        $this->lotes = Lote::all();
        $this->tareasFiltradas = $this->tareas;
    }


    public function buscarTarea()
    {
        $this->tareasFiltradas = $this->tareas->filter(function ($tarea) {
            return stripos($tarea->tarea, $this->searchTerm) !== false || 
                   stripos($tarea->code, $this->searchTerm) !== false;
        });
    }

    public function crearTareaLoteExt()
    {
       $datos = $this->validate();

       try {
            $plan_semanal_finca = PlanSemanalFinca::find($datos['plan_semanal_finca_id']);
            $lote = Lote::where('id', $datos['lote_id'])->where('finca_id', $plan_semanal_finca->finca->id)->first();
            if(!$lote)
            {
                $this->addError('error','El lote seleccionado no coincide con la finca del plan seleccionado');
                return;
            }

            $tarealote = TareasLote::create([
                'plan_semanal_finca_id' => $datos['plan_semanal_finca_id'],
                'lote_id' => $datos['lote_id'],
                'tarea_id' => $datos['tarea_id'],
                'personas' => $datos['personas'],   
                'presupuesto' => $datos['presupuesto'],
                'horas' => $datos['horas'],
                'cupos' => $datos['personas'],
                'horas_persona' => $datos['personas'],
                'extraordinaria' => 1

            ]);

            if(count($this->insumos) > 0)
            {
                foreach ($this->insumos as $insumo) {
                    InsumoTarea::create([
                        'insumo_id' => $insumo['id'],
                        'tarea_lote_id' => $tarealote->id,
                        'cantidad_asignada' => $insumo['cantidad'],
                    ]);
                }
                
            }

       } catch (\Throwable $th) {
            $this->addError('error','Existe un error al crear la tarea extraordinaria, intentelo de nuevo o comuniquese con el administrador' . $th->getMessage());
            return;
       }
       

        return redirect()->route('planSemanal')->with('success','Tarea creada Correctamente');
    }

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function agregarInsumo($insumo)
    {
        try {
            $this->insumos[] = $insumo;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function eliminarInsumo($id_insumo)
    {
        $updatedInsumos = collect($this->insumos)->filter(function($insumo) use($id_insumo){
           return $insumo['id_insumo'] !== $id_insumo;
        });
        $this->insumos = $updatedInsumos;
    }  
    
    public function editInsumo($id_insumo)
    {
        $this->openEditing = true;
        $this->editingInsumo = collect($this->insumos)->filter(function($insumo) use($id_insumo){
            return $insumo['id_insumo'] === $id_insumo;
        })->first();
        
    }
    
    public function editInsumos($insumos)
    {
        $this->insumos = $insumos;
    }

    public function closeModalCantidad()
    {
        $this->openEditing = false;
    }

    public function render()
    {
        return view('livewire.crear-tarea-lote');
    }
}
