<?php

namespace Database\Seeders;

use App\Models\Cultivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CultivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cultivos = [
            ['cultivo' => 'BROCOLI', 'rendimiento' => 960, 'semanas' => 13],
            ['cultivo' => 'EJOTE', 'rendimiento' => 1, 'semanas' => 1],
            ['cultivo' => 'MAIZ', 'rendimiento' => 1, 'semanas' => 1],
            ['cultivo' => 'FRESA', 'rendimiento' => 1, 'semanas' => 1],
        ];

        Cultivo::insert($cultivos);
    }
}
