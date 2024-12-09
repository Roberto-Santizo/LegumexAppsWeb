<?php

namespace App\Imports;

use App\Exceptions\ImportExeption;
use App\Models\Insumo;
use App\Models\InsumoTarea;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InsumosTareasSemanalesImport implements ToCollection, WithHeadingRow
{
    private $tareasMap;

    public function __construct(&$tareasMap)
    {
        $this->tareasMap = &$tareasMap;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['id_tarea'])) {
                return null;
            }
            
            try {
                $tareaLote = $this->tareasMap[$row['id_tarea']];
                $insumo = Insumo::where('code',$row['insumo'])->get()->first();

                InsumoTarea::create([
                    'insumo_id' => $insumo->id,
                    'tarea_lote_id' => $tareaLote,
                    'cantidad_asignada' => $row['cantidad']
                ]);
            } catch (\Throwable $th) {
                throw new ImportExeption('Existe un error al crear el plan semanal, verifique los datos del archivo e intentelo de nuevo');
            }
           
        }
    }
}
