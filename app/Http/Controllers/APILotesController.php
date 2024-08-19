<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APILotesController extends Controller
{
    
    public function lotes($finca_id)
    {
        $fincas = DB::table('lotes')
        ->where('finca_id', '=', $finca_id)
        ->get();

        $data = [ 
            'fincas' => $fincas,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

  
}
