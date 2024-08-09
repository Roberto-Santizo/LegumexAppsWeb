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
            ['name' => 'MELVIN EMILIO DE LEON', 'role_id' => 5, 'status' => 1],
            ['name' => 'CARLOS ROQUEL SARAVIA', 'role_id' => 5, 'status' => 1],
            ['name' => 'SILVIA LETICIA VELASQUEZ MELENDEZ', 'role_id' => 5, 'status' => 1],
            ['name' => 'LILIAN ESPERANZA QUISQUINAY', 'role_id' => 5, 'status' => 1],
            ['name' => 'ABNER CASTAÑEDA', 'role_id' => 5, 'status' => 1],
            ['name' => 'FREDDY LAURIANO BUCH CIPRIANO', 'role_id' => 5, 'status' => 1],
            ['name' => 'ELIZABETH MARLENY XIA SATZ', 'role_id' => 5, 'status' => 1],
            ['name' => 'ENRIQUE PELICO PEREZ', 'role_id' => 5, 'status' => 1],
            ['name' => 'JHON ANIBAL RODAS', 'role_id' => 5, 'status' => 1],
            ['name' => 'MEDELYN LISCELY COLCHAJ SULA', 'role_id' => 5, 'status' => 1],
            ['name' => 'GUMERCINDA ZAMOR CHIQUITA', 'role_id' => 5, 'status' => 1],
            ['name' => 'DEYCY SUCELI SULE AJGUALIPE', 'role_id' => 5, 'status' => 1],
            ['name' => 'MARDOQUEO COLO GUIGUI', 'role_id' => 5, 'status' => 1],
            ['name' => 'PEDRO AMILCAR VALLE TEJAXUN', 'role_id' => 5, 'status' => 1],
            ['name' => 'ABNER RIGOBERTO SAPUT LOPEZ', 'role_id' => 5, 'status' => 1],
            ['name' => 'MARCO ANTONIO GARCIA SABANA', 'role_id' => 5, 'status' => 1],
            ['name' => 'ANJY MARISOL XICON BAUTISTA', 'role_id' => 5, 'status' => 1],
            ['name' => 'ESTEFANY LOPEZ', 'role_id' => 5, 'status' => 1],
            ['name' => 'GLENDY PAOLA BUCH', 'role_id' => 5, 'status' => 1],
            ['name' => 'MANUEL HERNANDEZ', 'role_id' => 5, 'status' => 1],

            ['name' => 'MISHEL RAQUEC', 'role_id' => 4, 'status' => 1],
            ['name' => 'BRENDA MORALES', 'role_id' => 4, 'status' => 1],
            ['name' => 'ALEXANDER SAL', 'role_id' => 4, 'status' => 1],
            ['name' => 'VICTOR JEREZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'JOSUE SIQUINAJAY', 'role_id' => 4, 'status' => 1],
            ['name' => 'LILIANA SANCIR', 'role_id' => 4, 'status' => 1],
            ['name' => 'ANDREA MARQUEZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'LESLY AJGUALIPE', 'role_id' => 4, 'status' => 1],
            ['name' => 'NANCY UZEN', 'role_id' => 4, 'status' => 1],
            ['name' => 'ALVARO TALA', 'role_id' => 4, 'status' => 1],
            ['name' => 'JOSUE ORLANDO SIQUINAJAY ESPITAL', 'role_id' => 4, 'status' => 1],
            ['name' => 'LILIANA SANCIR OVALLE', 'role_id' => 4, 'status' => 1],
            ['name' => 'RENE ARTURO COLCHAJ CHIQUITO', 'role_id' => 4, 'status' => 1],
            ['name' => 'ALVARO TALA MENDEZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'LUIS FERNANDO MARTINEZ VELASCO', 'role_id' => 4, 'status' => 1],
            ['name' => 'ROLANDO DE JESUS XOQUIC PAZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'ANDREA ELIZABETH MARQUEZ MARQUEZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'LESLI ARACELI AJGUALIPE LARES', 'role_id' => 4, 'status' => 1],
            ['name' => 'NANCY NOEMI UZEN GOMEZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'JAMBLIN OBED VELASQUEZ IXLA', 'role_id' => 4, 'status' => 1],
            ['name' => 'MARIA ANDREA GARCIA SEQUEN', 'role_id' => 4, 'status' => 1],
            ['name' => 'OSVELIN ELIESER SET PEREZ', 'role_id' => 4, 'status' => 1],
            ['name' => 'JENRI ARNOLDO HERNANDEZ BALUX', 'role_id' => 4, 'status' => 1],
            ['name' => 'LESLI ARACELI AJGUALIPE LARES', 'role_id' => 4, 'status' => 1],
        ];

        Supervisor::insert($supervisores);
    }
}
