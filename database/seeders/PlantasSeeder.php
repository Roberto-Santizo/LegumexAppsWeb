<?php

namespace Database\Seeders;

use App\Models\Planta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plantas = [
            ['planta' => 'Congelado Tejar'],
            ['planta' => 'FRESCO'],
            ['planta' => 'Planta El Tejar'],
            ['planta' => 'Planta Parramos'],
            ['planta' => 'Planta AB'],
        ];

        Planta::insert($plantas); 
    }
}
