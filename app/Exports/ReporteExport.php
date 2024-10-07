<?php

namespace App\Exports;

use App\Models\EmpleadoFinca;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReporteExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EmpleadoFinca::all();
    }
}
