<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['estado' => 'En Proceso'],
            ['estado' => 'En revisión'],
            ['estado' => 'Cerradas'],
            ['estado' => 'Atrasadas'],
            ['estado' => 'Eliminada'],
            ['estado' => 'Rechazada'],
        ];
        
        Estado::insert($data); 
    }
}
