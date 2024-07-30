<?php

namespace Database\Seeders;

use App\Models\Herramienta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HerramientasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $herramientas = [
            ['herramienta' => 'Caja de Herramientas'],
            ['herramienta' => 'Martillo'],
            ['herramienta' => 'Alicate'],
            ['herramienta' => 'Metro'],
            ['herramienta' => 'Cinta de Aislar Scotch / Termoencogible'],
            ['herramienta' => 'Desarmador Plano'],
            ['herramienta' => 'Desarmador Philips'],
            ['herramienta' => 'Ajustable'],
            ['herramienta' => 'Juego de Hexagonales'],
            ['herramienta' => 'Amperímetro'],
            ['herramienta' => 'Llaves cola corona # 8,10,11,13,14,19'],
        ];
        
        Herramienta::insert($herramientas); 
    }
}
