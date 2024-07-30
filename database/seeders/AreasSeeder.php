<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['id' => 1, 'area' => 'RECEPCIÓN MATERIA PRIMA', 'planta_id' => 1],
            ['id' => 2, 'area' => 'CUARTO MATERIA PRIMA', 'planta_id' => 1],
            ['id' => 3, 'area' => 'LAVADORA DE RODILLOS', 'planta_id' => 1],
            ['id' => 4, 'area' => 'PREPARACIÓN', 'planta_id' => 1],
            ['id' => 5, 'area' => 'PROCESO', 'planta_id' => 1],
            ['id' => 6, 'area' => 'REEMPAQUE', 'planta_id' => 1],
            ['id' => 7, 'area' => 'HOLDING PRODUCTO TERMINADO', 'planta_id' => 1],
            ['id' => 8, 'area' => 'BAHÍA EMBARQUES', 'planta_id' => 1],
            ['id' => 9, 'area' => 'ADUANA', 'planta_id' => 1],
            ['id' => 10, 'area' => 'BODEGA SECA', 'planta_id' => 1],
            ['id' => 11, 'area' => 'RECEPCIÓN MATERIA PRIMA', 'planta_id' => 2],
            ['id' => 12, 'area' => 'CUARTO MATERIA PRIMA', 'planta_id' => 2],
            ['id' => 13, 'area' => 'PREPARACIÓN', 'planta_id' => 2],
            ['id' => 14, 'area' => 'LAVADO', 'planta_id' => 2],
            ['id' => 15, 'area' => 'EMPAQUE', 'planta_id' => 2],
            ['id' => 16, 'area' => 'HOLDING PRODUCTO TERMINADO', 'planta_id' => 2],
            ['id' => 17, 'area' => 'BAHÍA EMBARQUES', 'planta_id' => 2],
            ['id' => 18, 'area' => 'ADUANA', 'planta_id' => 2],
            
            ['id' => 19, 'area' => 'ADMINISTRACION', 'planta_id' => 3],
            ['id' => 20, 'area' => 'MANTENIMIENTO', 'planta_id' => 3],
            ['id' => 21, 'area' => 'GARITA', 'planta_id' => 3],
            ['id' => 22, 'area' => 'BODEGAS', 'planta_id' => 3],
            ['id' => 23, 'area' => 'OTROS', 'planta_id' => 3],
            
            ['id' => 24, 'area' => 'ADMINISTRACION', 'planta_id' => 4],
            ['id' => 25, 'area' => 'MANTENIMIENTO', 'planta_id' => 4],
            ['id' => 26, 'area' => 'GARITA', 'planta_id' => 4],
            ['id' => 27, 'area' => 'BODEGAS', 'planta_id' => 4],
            ['id' => 28, 'area' => 'OTROS', 'planta_id' => 4],

            ['id' => 29, 'area' => 'ADUANA', 'planta_id' => 5],
            ['id' => 30, 'area' => 'PREPARACIÓN', 'planta_id' => 5],
            ['id' => 31, 'area' => 'PROCESO TANQUES', 'planta_id' => 5],
            ['id' => 32, 'area' => 'EMBOTELLADO', 'planta_id' => 5],
            ['id' => 33, 'area' => 'HPP', 'planta_id' => 5],
            ['id' => 34, 'area' => 'CUARTO FRIO PRODUCTO TERMINADO', 'planta_id' => 5],
            ['id' => 35, 'area' => 'EMBARQUES', 'planta_id' => 5],
            ['id' => 36, 'area' => 'MATENIMIENTO', 'planta_id' => 5],
            ['id' => 37, 'area' => 'REEMPAQUE', 'planta_id' => 5],
        ];
        
        Area::insert($areas);
    }
}
