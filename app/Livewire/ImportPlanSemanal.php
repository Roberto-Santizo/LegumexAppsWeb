<?php

namespace App\Livewire;

use Livewire\Component;
use App\Imports\PlanSemanalImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ImportPlanSemanal extends Component
{
    use WithFileUploads;

    public $archivo;


    protected $rules = [
        'archivo' => 'required',
    ];

    public function render()
    {
        return view('livewire.import-plan-semanal');
    }

    public function crearPlan()
    {

        Excel::import(new PlanSemanalImport, $this->archivo);

        return redirect()->route('planSemanal')->with('success', 'Plan Semanal Creado Correctamente');
    }
}
