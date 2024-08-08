<?php

namespace Database\Seeders;

use App\Models\Supervisor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupervisoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supervisores = [
            ['name' => 'MELVIN EMILIO DE LEON', 'role_id' => 5],
            ['name' => 'CARLOS ROQUEL SARAVIA', 'role_id' => 5],
            ['name' => 'SILVIA LETICIA VELASQUEZ MELENDEZ', 'role_id' => 5],
            ['name' => 'LILIAN ESPERANZA QUISQUINAY', 'role_id' => 5],
            ['name' => 'ABNER CASTAÑEDA', 'role_id' => 5],
            ['name' => 'FREDDY LAURIANO BUCH CIPRIANO', 'role_id' => 5],
            ['name' => 'ELIZABETH MARLENY XIA SATZ', 'role_id' => 5],
            ['name' => 'ENRIQUE PELICO PEREZ', 'role_id' => 5],
            ['name' => 'JHON ANIBAL RODAS', 'role_id' => 5],
            ['name' => 'MEDELYN LISCELY COLCHAJ SULA', 'role_id' => 5],
            ['name' => 'GUMERCINDA ZAMOR CHIQUITA', 'role_id' => 5],
            ['name' => 'DEYCY SUCELI SULE AJGUALIPE', 'role_id' => 5],
            ['name' => 'MARDOQUEO COLO GUIGUI', 'role_id' => 5],
            ['name' => 'PEDRO AMILCAR VALLE TEJAXUN', 'role_id' => 5],
            ['name' => 'ABNER RIGOBERTO SAPUT LOPEZ', 'role_id' => 5],
            ['name' => 'MARCO ANTONIO GARCIA SABANA', 'role_id' => 5],
            ['name' => 'ANJY MARISOL XICON BAUTISTA', 'role_id' => 5],
            ['name' => 'ESTEFANY LOPEZ', 'role_id' => 5],
            ['name' => 'GLENDY PAOLA BUCH', 'role_id' => 5],
            ['name' => 'MANUEL HERNANDEZ', 'role_id' => 5],

            ['name' => 'MISHEL RAQUEC', 'role_id' => 4],
            ['name' => 'BRENDA MORALES', 'role_id' => 4],
            ['name' => 'ALEXANDER SAL', 'role_id' => 4],
            ['name' => 'VICTOR JEREZ', 'role_id' => 4],
            ['name' => 'JOSUE SIQUINAJAY', 'role_id' => 4],
            ['name' => 'LILIANA SANCIR', 'role_id' => 4],
            ['name' => 'ANDREA MARQUEZ', 'role_id' => 4],
            ['name' => 'LESLY AJGUALIPE', 'role_id' => 4],
            ['name' => 'NANCY UZEN', 'role_id' => 4],
            ['name' => 'ALVARO TALA', 'role_id' => 4],
            ['name' => 'MOISES CUM', 'role_id' => 4],
        ];

        Supervisor::insert($supervisores);
    }
}
