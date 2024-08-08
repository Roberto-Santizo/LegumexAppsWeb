<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
        {
            return [
                'role_or_permission:admin',
            ];
        }
    
    
    public function index()
    {
        $roles = Role::paginate(5);
        return view('administracion.usuarios.roles.index',['roles'=>$roles]);
    }

    public function create()
    {
        return view('administracion.usuarios.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        Role::create([
            'name' => $request->name,
            'guard_name' =>'web'
        ]);

        return redirect()->route('usuarios.roles')->with(['success' => 'El rol fue creado exitosamente']);
    }

    public function edit(Role $role)
    {
        return view('administracion.usuarios.roles.edit',['role' => $role]);
    }

    public function update(Role $role, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required'
            ]);
    
            $role->name = $request->name;
            $role->save();
    
            return redirect()->route('usuarios.roles')->with('success','El rol ha sido modificado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','Hubo un error al crear el rol, intentelo de nuevo más tarde');
        }
    }
    
}
