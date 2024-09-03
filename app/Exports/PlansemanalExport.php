<?php

namespace App\Exports;

use App\Models\PlanSemanalFinca;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlansemanalExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $plansemanalfincas = PlanSemanalFinca::all();

        return $plansemanalfincas->map(function($plansemanal){
            return [
                'Número de Semana' => $plansemanal->semana,
                'Nombre de Finca' => $plansemanal->finca->finca
            ];
        });

    }

    public function headings(): array
    {
        return ['Número de Semana', 'Nombre de Finca'];
    }
}
