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
            ['name' => 'Congelado Tejar'],
            ['name' => 'FRESCO'],
            ['name' => 'Planta El Tejar'],
            ['name' => 'Planta Parramos'],
            ['name' => 'Planta AB'],
        ];

        Planta::insert($plantas); 
    }
}
