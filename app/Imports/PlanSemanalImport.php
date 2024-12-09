<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlanSemanalImport implements WithMultipleSheets
{
    private $tareasMap = [];
  
    public function sheets() : array 
    {
        return [
            0 => new TareasSemanalesImport($this->tareasMap),
            1 => new InsumosTareasSemanalesImport($this->tareasMap)
        ];
    }
       
}
