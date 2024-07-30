<?php

namespace Database\Seeders;

use App\Http\Controllers\HerramientasController;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}
