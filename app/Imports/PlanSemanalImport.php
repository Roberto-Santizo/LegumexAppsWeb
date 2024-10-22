<?php

namespace App\Imports;

use App\Exceptions\ImportExeption;
use App\Models\Lote;
use App\Models\Finca;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\PlanSemanalFinca;
use App\Models\TareaCosecha;
use App\Models\TareaLoteCosecha;
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

        $finca = Finca::where('code',$row['finca'])->get()->first();
        if (!$finca) {
            throw new ImportExeption('La finca ' . $row['finca'] . ' no existe');
        }

        $planSemanal = $this->getOrCreatePlanSemanal($row['finca'], $row['numero_de_semana']);

        $lote = Lote::where('nombre', $row['lote'])->where('finca_id',$finca->id)->first();

        if (!$lote) {
            throw new ImportExeption('El lote ' . $row['lote'] . ' no existe o pertenece a otra finca');
        }

        $tarea = Tarea::where('code', $row['tarea'])->first();

        if($tarea){
            try {
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
            } catch (\Throwable $th) {
                throw new ImportExeption('Existe un error en los datos del archivo');
            }
            
        }else{
            $tarea = TareaCosecha::where('code',$row['tarea'])->first();

            try {
                return new TareaLoteCosecha([
                    'plan_semanal_finca_id' => $planSemanal->id,
                    'lote_id' => $lote->id,
                    'tarea_cosecha_id' => $tarea->id,
                ]);
            } catch (\Throwable $th) {
                throw new ImportExeption('Existe un error en los datos');
            }
            
        }

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

        $this->planesSemanal[$finca][$numeroSemana] = $planSemanal;

        return $planSemanal;
    }
}
