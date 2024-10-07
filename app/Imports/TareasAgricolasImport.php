<?php
namespace App\Imports;

use App\Models\Tarea;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TareasAgricolasImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Verifica si los campos clave están vacíos
            if (empty($row['code']) || empty($row['tarea'])) {
                continue; // Si faltan datos clave, omite esta fila
            }

            // Crea y guarda cada nueva tarea
            Tarea::create([
                'code' => $row['code'],
                'tarea' => $row['tarea'],
                'descripcion' => $row['descripcion'] ?? 'SIN DESCRIPCIÓN'
            ]);
        }
    }
}