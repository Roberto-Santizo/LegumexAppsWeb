<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    public function index()
    {
        $permissions = Permission::paginate(5);
        return view('administracion.usuarios.permissions.index',['permissions'=>$permissions]);
    }

    public function create()
    {
        return view('administracion.usuarios.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        Permission::create([
            'name' => $request->name,
            'guard_name' =>'web'
        ]);

        return redirect()->route('permissions')->with(['success' => 'El permiso fue creado exitosamente']);
    }

    public function edit(Permission $permission)
    {
        return view('administracion.usuarios.permissions.edit',['permission' => $permission]);
    }

    public function update(Permission $permission, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required'
            ]);
    
            $permission->name = $request->name;
            $permission->save();
    
            return redirect()->route('permissions')->with('success','El permiso ha sido modificado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','Hubo un error al crear el permiso, intentelo de nuevo más tarde');
        }
    }
    
}
