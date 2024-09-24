<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PlanSemanalFinca;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('dashboards.index');
    }

    public function mantenimiento()
    {
        
        return view('dashboards.mantenimiento');
    }

    public function agricola()
    {
        $planes = PlanSemanalFinca::where('semana',Carbon::now()->weekOfYear())->get();
        $planes->map(function($plan){
            $plan->tareasRealizadas = $plan->tareasTotales->filter(function($tarea){
                if($tarea->cierre){
                    return $tarea;
                }
            });

        });
        return view('dashboards.agricola',['planes' => $planes]);
    }
}
