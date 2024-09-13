<?php

namespace App\Imports;

use App\Models\Lote;
use App\Models\Finca;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\PlanSemanalFinca;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlanSemanalImport implements ToModel, WithHeadingRow
{
    private $planesSemanal = [];

    public function model(array $row)
    {
        // Valida que no falten datos clave
        if (empty($row['lote']) || empty($row['finca']) || empty($row['tarea']) || empty($row['numero_de_semana'])) {
            return null;
        }

        // Buscar o crear el Plan Semanal para la finca y semana actual
        $planSemanal = $this->getOrCreatePlanSemanal($row['finca'], $row['numero_de_semana']);

        // Buscar el lote y la tarea
        $lote = Lote::where('nombre', $row['lote'])->first();
        $tarea = Tarea::where('code', $row['tarea'])->first();

        if (!$lote || !$tarea) {
            logger()->warning('Lote o Tarea no encontrados para la fila: ', $row);
            return null;
        }

        // Crear una nueva tarea para ese lote
        return new TareasLote([
            'plan_semanal_finca_id' => $planSemanal->id,
            'lote_id' => $lote->id,
            'tarea_id' => $tarea->id,
            'personas' => (floor($row['horas'] / 8) < 1) ? 1 : floor($row['horas'] / 8),
            'presupuesto' => round($row['presupuesto'], 2),
            'horas' => round($row['horas'], 2),
            'cupos' => (floor($row['horas'] / 8) < 1) ? 1 : floor($row['horas'] / 8),
            'horas_persona' => $row['horas'] / $row['personas'],
        ]);
    }

    private function getOrCreatePlanSemanal($finca, $numeroSemana)
    {
        // Si ya tenemos este plan en cache, lo devolvemos
        if (isset($this->planesSemanal[$finca][$numeroSemana])) {
            return $this->planesSemanal[$finca][$numeroSemana];
        }

        $fincaModel = Finca::where('code',$finca)->get()->first();
        
        $planSemanal = PlanSemanalFinca::firstOrCreate(
            [
                'finca_id' => $fincaModel->id,
                'semana' => $numeroSemana,
            ]
        );

        // Almacenar el plan en cache
        $this->planesSemanal[$finca][$numeroSemana] = $planSemanal;

        return $planSemanal;
    }
}
