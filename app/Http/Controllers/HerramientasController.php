<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class HerramientasController extends Controller
{
    public function index(Request $request){ 
        $query = $request->get('query');
        if($query){
            $herramientas = Herramienta::query()
                ->where('herramienta','like', "%$query%")
                ->paginate(5);
        }else{
            $herramientas = Herramienta::paginate(5);
        }

        return view('mantenimiento.herramientas.index',['herramientas'=>$herramientas]);
    }

    public function create()
    {
        return view('mantenimiento.herramientas.create');
    }

    public function store(Request $request){ 
        $validated = $request->validate([
            'herramienta' => 'required|max:60'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $herramienta = Herramienta::create([
                    'herramienta' => $request->herramienta,
                ]);
            });
            
            return redirect()->route('herramientas')->with(['success' => 'Herramienta creada exitosamente']);
            
        } catch (\Throwable $th) { 
            return back()->with('error', 'Hubo un problema crear la herramienta. Inténtelo de nuevo más tarde');
        }
    }

    public function edit(Herramienta $herramienta){ 
        return view('mantenimiento.herramientas.edit',['herramienta'=>$herramienta]);
    }

    public function update(Herramienta $herramienta, Request $request)
    {
        try {
            $herramienta->update([
                'herramienta' => $request->herramienta
            ]);
            return redirect()->route('herramientas')->with('mensaje','Herramienta actualizada correctamente');
        } catch (\Throwable $th) {
            return back()->with('mensaje','Hubo un error al actualizar la herramienta, intentelo de nuevo más tarde');
        }
    }

    public function destroy(Herramienta $herramienta)
    {
        try {
            $herramienta->delete();
            return redirect()->route('herramientas')->with('success','Herramienta eliminada correctamente');
        } catch (\Throwable $th) {
            return back()->with('error','Hubo un error al actualizar la herramienta, intentelo de nuevo más tarde');
        }
       
    }
}
