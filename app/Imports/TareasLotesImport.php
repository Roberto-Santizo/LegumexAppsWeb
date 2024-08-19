<?php

namespace App\Imports;

use Log;
use App\Models\Lote;
use App\Models\Finca;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\PlanSemanalFinca;
use Illuminate\Support\Facades\Log as FacadesLog;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TareasLotesImport implements ToModel, WithHeadingRow
{
    protected $planSemanal;

    public function __construct(PlanSemanalFinca $planSemanal)
    {
        $this->planSemanal = $planSemanal;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row['lote']) || empty($row['finca']) || empty($row['tarea'])) {
            // Omitir la fila si falta algún dato clave
            return null;
        }

        $lote = Lote::where('nombre',$row['lote'])->first();
        $tarea = Tarea::where('code',$row['tarea'])->first();
        
        return new TareasLote([
            'plan_semanal_finca_id' => $this->planSemanal->id,
            'lote_id' => $lote->id,
            'tarea_id' => $tarea->id,
            'personas' => $row['personas'],
            'presupuesto' => $row['presupuesto'],
            'horas' => $row['horas'],
            'tarifa' => $row['tarifa'],
        ]);
    }
}
