<?php

namespace App\Imports;

use App\Models\Lote;
use App\Models\Finca;
use App\Models\Tarea;
use App\Models\TareasLote;
use App\Models\TareaCosecha;
use Illuminate\Support\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\TareaLoteCosecha;
use App\Exceptions\ImportExeption;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlanSemanalImport implements ToModel, WithHeadingRow
{
    private $planesSemanal = [];
    private $fincas;
    private $tareas;

    public function __construct()
    {
        // Carga todas las fincas y tareas en memoria para evitar consultas repetitivas
        $this->fincas = Finca::all()->keyBy('code');
        $this->tareas = Tarea::all()->keyBy('code');
    }

    public function model(array $row)
    {
        if (empty($row['finca']) || empty($row['lote']) || empty($row['tarea']) || empty($row['horas']) || empty($row['presupuesto'])) {
            return null; 
        }

        $semana = Carbon::now()->weekOfYear;

        try {
            $finca = $this->fincas[$row['finca']] ?? null;
            if (!$finca) {
                throw new ImportExeption("Finca con código {$row['finca']} no encontrada.");
            }

            $lote = Lote::where('nombre', $row['lote'])->where('finca_id', $finca->id)->first();
            $tarea = $this->tareas[$row['tarea']] ?? TareaCosecha::where('code', $row['tarea'])->first();
            $planSemanal = $this->getOrCreatePlanSemanal($finca->code, $row['numero_de_semana']);

            if ($row['numero_de_semana'] < $semana) {
                throw new ImportExeption("La semana indicada es anterior a la semana actual.");
            }

            if ($tarea instanceof Tarea) {
                return new TareasLote([
                    'plan_semanal_finca_id' => $planSemanal->id,
                    'lote_id' => $lote->id,
                    'tarea_id' => $tarea->id,
                    'personas' => max(1, floor($row['horas'] / 8)),
                    'presupuesto' => round($row['presupuesto'], 2),
                    'horas' => round($row['horas'], 2),
                    'cupos' => max(1, floor($row['horas'] / 8)),
                    'horas_persona' => $row['horas'] / $row['personas'],
                ]);
            }

            return new TareaLoteCosecha([
                'plan_semanal_finca_id' => $planSemanal->id,
                'lote_id' => $lote->id,
                'tarea_cosecha_id' => $tarea->id,
            ]);

        } catch (\Throwable $th) {
            throw new ImportExeption('Existe un error al crear el plan semanal, verifique los datos del archivo e intentelo de nuevo');
        }
    }

    private function getOrCreatePlanSemanal($finca, $numeroSemana)
    {
        if (isset($this->planesSemanal[$finca][$numeroSemana])) {
            return $this->planesSemanal[$finca][$numeroSemana];
        }

        $fincaModel = $this->fincas[$finca] ?? null;
        if (!$fincaModel) {
            throw new ImportExeption("Finca con código {$finca} no encontrada.");
        }

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
