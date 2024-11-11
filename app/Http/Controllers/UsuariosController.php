<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UsuariosController extends Controller 
{
  
    public function index(Request $request)
    { 
        $query = $request->get('query');
        if($query){
            $usuarios = User::query()
                ->where('name','like', "%$query%")
                ->Orwhere('username','like', "%$query%")
                ->paginate(5);
        }else{
            $usuarios = User::paginate(50);
        }
        
        return view('administracion.usuarios.index',['usuarios' => $usuarios]);
    }
    
    public function create()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('administracion.usuarios.create',['roles'=>$roles, 'permisos' => $permissions]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'password' => 'required|min:6',
            'role_id' => 'required',
        ]);

        try {
            $role = Role::findOrFail($request->role_id);     
            $usuario = User::create([
                'name' => $request->name,
                'username' => Str::slug($request->username),
                'email' => $request->email ?? null,
                'password' => $request->password,
                'status' => 1
            ])->assignRole($role->name);

            if($request->permisos){
                foreach ($request->permisos as $key => $value) {
                    $permiso = Permission::find($value);
                    $usuario->givePermissionTo($permiso);
                }
            }
            
            return redirect()->route('usuarios')->with('success','Usuario creado exitosamente');
        } catch (\Exception $e) {
            return back()->with(['mensaje' => 'Hubo un problema al crear el usuario.']);
        }
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        $permissions_usuarios = $usuario->getAllPermissions();
        $permissions = Permission::all();
        return view('administracion.usuarios.edit',['usuario' => $usuario, 'roles' => $roles, 'permisos_usuarios' => $permissions_usuarios, 'permisos' => $permissions]);
    }
    
    public function update(User $usuario, Request $request)
    {
        try {
            $role = Role::findOrFail($request->role_id);
            
            // Actualiza los datos del usuario
            $usuario->name = $request->name;
            $usuario->username = $request->username;
            $usuario->email = $request->email;
            if ($request->password) {
                $usuario->password = bcrypt($request->password);
            }
            
            // Obtiene el rol actual del usuario
            $currentRole = $usuario->getRoleNames()->first();
            
            // Si el rol ha cambiado, sincroniza los roles y permisos
            if ($role->name != $currentRole) {
                $usuario->syncRoles([$role->name]);
            }
    
            // Sincroniza los permisos del usuario
            $permisos = $request->input('permisos', []);
            $usuario->syncPermissions($permisos);
            
            $usuario->save();
            
            return redirect()->route('usuarios')->with('success', 'Usuario actualizado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error', $th);
        }
    }
    
    
    public function destroy(User $usuario)
    {
        try {
            if($usuario->status == 0){
                $usuario->status = 1;
            }else{
                $usuario->status = 0;
            }

            $usuario->save();

            return redirect()->route('usuarios')->with('success','Usuario modificado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','Hubo un error al modificar el usuario, intentelo de nuevo más tarde');
        }
    }
}
