<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FirmaController extends Controller
{
    public function store(Request $request){
        try {
            $firmas = [];
            foreach ($request->files as $key => $file) {
                if ($file->isValid()) {
                    $nombreFirma = Str::uuid() . '.png';
                    $file->move(public_path('uploads'), $nombreFirma);
                    $firmas[$key] = $nombreFirma;
                }
            }
        
            return response()->json(['imagenes' => $firmas, 'status' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ha habido un error al guardar las firmas, intentelo de nuevo más tarde', 'status' => 500], 500);
        }
        
    }
}
