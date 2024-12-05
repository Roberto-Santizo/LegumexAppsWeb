<?php
namespace App\Imports;

use App\Models\Insumo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InsumosImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if (empty($row['code']) || empty($row['insumo'])) {
                continue; 
            }

            Insumo::create([
                'code' => $row['code'],
                'insumo' => $row['insumo'],
            ]);
        }
    }
}
