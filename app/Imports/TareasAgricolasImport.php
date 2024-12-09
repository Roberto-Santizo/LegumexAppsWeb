<?php
namespace App\Imports;

use App\Exceptions\ImportExeption;
use App\Models\Tarea;
use Illuminate\Support\Collection;
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
            try {
                if (empty($row['code']) || empty($row['tarea'])) {
                    continue; 
                }
    
                // Crea y guarda cada nueva tarea
                Tarea::create([
                    'code' => $row['code'],
                    'tarea' => $row['tarea'],
                    'descripcion' => $row['descripcion'] ?? 'SIN DESCRIPCIÓN'
                ]);
            } catch (\Exception $e) {
                throw new ImportExeption($e->getMessage());
            }
            
        }
    }
}
