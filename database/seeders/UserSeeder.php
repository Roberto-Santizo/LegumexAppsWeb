<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = User::create([
            'name' => 'Roberto Santizo',
            'email' => 'soportetecnico.tejar@legumex.net',
            'password' => 'admin',
            'username' => 'admin'
        ])->assignRole('admin');
        
        $permissions = Permission::all();

        foreach($permissions as $permiso){
           $usuario->givePermissionTo($permiso);
        }
    }
}
