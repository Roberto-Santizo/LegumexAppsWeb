<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIAreasController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return response()->json($areas,200);
    }

    public function show($planta_id)
    {
        $areas = DB::table('areas')
        ->where('planta_id', '=', $planta_id)
        ->get();

        $data = [ 
            'areas' => $areas,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function elementos($area_id)
    {
        $elementos = DB::table('elementos')
        ->where('area_id', '=', $area_id)
        ->get();

        $data = [ 
            'elementos' => $elementos,
            'status' => 200
        ];
        return response()->json($data, 200); 
    }
}
