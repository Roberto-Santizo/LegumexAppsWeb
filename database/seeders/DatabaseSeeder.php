<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EstadosSeeder::class);

        $this->call(PlantasSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(ElementosSeeder::class);
        $this->call(HerramientasSeeder::class);
        $this->call(SupervisoresSeeder::class);

        $this->call(CultivosSeeder::class);
        $this->call(FincaSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(CultivosSeeder::class);
        $this->call(TareasCosechaSeeder::class);
    }
}
