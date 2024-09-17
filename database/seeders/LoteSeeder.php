<?php

namespace Database\Seeders;

use App\Models\Lote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = [
            ['nombre' => 'FALI001', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FALI002', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FALI003', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FALI004', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FALI006', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FALI007', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FALI005', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL001', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL002', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL003', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL004', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL005', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL006', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL007', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL008', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL009', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FAL010', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'EXPERIMENTAL', 'finca_id' => 8, 'estado' => 1],
            ['nombre' => 'FLS-001', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-002', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-003', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-004', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-005', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-006', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-007', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-008', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-009', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-010', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-011', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-012', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-013', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-014', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-015', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-016', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-017', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-018', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-019', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-020', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-021', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-022', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-023', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-024', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-026', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FLS-025', 'finca_id' => 5, 'estado' => 1],
            ['nombre' => 'FOV-001', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-002', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-003', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-004', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-005', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-006', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-007', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-008', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-009', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-010', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-011', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FOV-012', 'finca_id' => 9, 'estado' => 1],
            ['nombre' => 'FT-001', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-002', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-003', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-004', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-005', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-006', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-007', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-008', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-009', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-010', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-011', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-012', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-013', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-014', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-015', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FT-016', 'finca_id' => 4, 'estado' => 1],
            ['nombre' => 'FV-001', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-002', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-003', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-004', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-005', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-006', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-007', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-008', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-009', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-010', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-011', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-012', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-013', 'finca_id' => 6, 'estado' => 1],
            ['nombre' => 'FV-014', 'finca_id' => 6, 'estado' => 1],
        ];

        Lote::insert($lotes);
    }
}
