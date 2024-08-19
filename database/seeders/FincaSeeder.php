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
            ['finca' => 'Finca la Alameda'],
            ['finca' => 'Finca el Ovejero'],
            ['finca' => 'Finca Tehuya'],
            ['finca' => 'Finca Victoria'],
            ['finca' => 'Finca Linda Sofia'],
        ];

        Finca::insert($fincas);
    }
}
