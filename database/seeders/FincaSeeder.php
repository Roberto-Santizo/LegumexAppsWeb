<?php

namespace Database\Seeders;

use App\Models\Finca;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FincaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fincas = [
            ['id' => 8, 'finca' => 'FINCA ALAMEDA', 'code' => 'FAL'],
            ['id' => 5, 'finca' => 'FINCA LINDA SOFIA 1', 'code' => 'FLS1'],
            ['id' => 7, 'finca' => 'FINCA LINDA SOFIA 2', 'code' => 'FLS2'],
            ['id' => 4, 'finca' => 'FINCA TEHUYA', 'code' => 'FT'],
            ['id' => 6, 'finca' => 'FINCA VICTORIA', 'code' => 'FV'],
            ['id' => 9, 'finca' => 'FINCA OVEJERO', 'code' => 'FOV'],
        ];

        Finca::insert($fincas);
    }
}
