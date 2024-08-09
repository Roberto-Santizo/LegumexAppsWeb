<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;

class APISupervisoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function supervisoresAreas()
    {
        $supervisores = Supervisor::all()->where('role_id',4)->where('status',1);
        foreach ($supervisores as $supervisor) {
            $supervisor->rol = $supervisor->role->name;
        }
        return response()->json($supervisores,200);
    }

}
