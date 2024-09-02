<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class SupervisoresController extends Controller implements HasMiddleware
{
    public static function middleware(): array
        {
            return [
                'role_or_permission:admin',
            ];
        }
    
    
    public function index(Request $request)
    {

        $query = $request->get('query');
        if($query){
            $supervisores = Supervisor::query()
                ->where('name','like', "%$query%")
                ->paginate(10)
                ->appends($request->all());
        }else{
            $supervisores = Supervisor::paginate(10)->appends($request->all());
        }

        return view('administracion.usuarios.supervisores.index',['supervisores'=>$supervisores]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('administracion.usuarios.supervisores.create',['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role_id' => 'required',
        ]);

        Supervisor::create([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'status' => 1

        ]);

        return redirect()->route('usuarios.supervisores')->with(['success' => 'El supervisor fue creado exitosamente']);
    }

    public function edit(Supervisor $supervisor)
    {
        $roles = Role::all()->whereIn('id',[4,5]);
        return view('administracion.usuarios.supervisores.edit',['supervisor' => $supervisor, 'roles' => $roles]);
    }

    public function update(Supervisor $supervisor, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'role_id' => 'required'
            ]);
    
            $supervisor->name = $request->name;
            $supervisor->role_id = $request->role_id;
            $supervisor->save();
    
            return redirect()->route('usuarios.supervisores')->with('success','El supervisor ha sido modificado correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','Hubo un error al editar el supervisor, intentelo de nuevo más tarde');
        }
    }

    public function destroy(Supervisor $supervisor, Request $request){
        try {
            if($supervisor->status == 0){
                $supervisor->status = 1;
            }else{
                $supervisor->status = 0;
            }
            
            $supervisor->save();
            return redirect()->route('usuarios.supervisores')->with('success','El supervisor fue modificado correctamente!');
        } catch (\Throwable $th) {
            return back()->with('error','Hubo un error al modificar el supervisor');
        }
    }
    
}