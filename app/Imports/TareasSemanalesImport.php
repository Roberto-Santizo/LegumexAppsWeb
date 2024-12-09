<?php

namespace App\Imports;

use App\Models\Tarea;
use App\Models\TareasLote;
use Illuminate\Support\Carbon;
use App\Exceptions\ImportExeption;
use App\Models\Finca;
use App\Models\Lote;
use App\Models\PlanSemanalFinca;
use App\Models\TareaCosecha;
use App\Models\TareaLoteCosecha;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TareasSemanalesImport implements ToCollection, WithHeadingRow
{
    private $tareasMap;
    private $planesSemanal = [];
    private $fincas;
    private $tareas;
    private $tareasCosechas;

    public function __construct(&$tareasMap)
    {
        $this->tareasMap = &$tareasMap;
        $this->fincas = Finca::all()->keyBy('code');
        $this->tareas = Tarea::all()->keyBy('code');
        $this->tareasCosechas = TareaCosecha::all()->keyBy('code');
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['id'])) {
                return null;
            }
            $fechaSemanaActual = Carbon::now();
            $fechaSemanaImportada = Carbon::now()->setISODate($row['year'], $row['numero_de_semana']);
            try {
                $finca = $this->fincas[$row['finca']] ?? null;
                if (!$finca) {
                    throw new ImportExeption("Finca con código {$row['finca']} no encontrada.");
                }

                if ($fechaSemanaImportada->isBefore($fechaSemanaActual)) {
                    throw new ImportExeption("La semana indicada es anterior a la semana actual.");
                }

                $lote = Lote::where('nombre', $row['lote'])->where('finca_id', $finca->id)->first();
                $tarea = $this->tareas[$row['tarea']] ?? $this->tareasCosechas[$row['tarea']];
                $planSemanal = $this->getOrCreatePlanSemanal($finca->code, $row['numero_de_semana'], $row['year']);

                if ($tarea instanceof Tarea) {
                   $tareaLote = TareasLote::create([
                        'plan_semanal_finca_id' => $planSemanal->id,
                        'lote_id' => $lote->id,
                        'tarea_id' => $tarea->id,
                        'personas' => max(1, floor($row['horas'] / 8)),
                        'presupuesto' => round($row['presupuesto'], 2),
                        'horas' => round($row['horas'], 2),
                        'cupos' => max(1, floor($row['horas'] / 8)),
                        'horas_persona' => $row['horas'] / $row['personas'],
                    ]);
                
                }else{
                    $tareaLote = TareaLoteCosecha::create([
                        'plan_semanal_finca_id' => $planSemanal->id,
                        'lote_id' => $lote->id,
                        'tarea_cosecha_id' => $tarea->id,
                    ]);
                }
    
                $this->tareasMap[$row['id']] = $tareaLote->id;
            } catch (\Throwable $th) {
                throw new ImportExeption('Existe un error al crear el plan semanal, verifique los datos del archivo e intentelo de nuevo');
            }
        }

    }

    private function getOrCreatePlanSemanal($finca, $numeroSemana, $anio)
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
                'year' => $anio
            ]
        );

        $this->planesSemanal[$finca][$numeroSemana] = $planSemanal;

        return $planSemanal;
    }
}
