<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $sessions = Session::limit(10)->get();

        $sessions->map(function($session){
            $last_activity = $session->last_activity;
            $last_activityDate = Carbon::createFromTimestamp($last_activity);

            $session->ultima_coneccion = $last_activityDate->format('d-m-Y');
        });

        return view('dashboards.index',['sessions' => $sessions]);
    }

    public function mantenimiento()
    {
        
        return view('dashboards.mantenimiento');
    }

    public function agricola()
    {

        return view('dashboards.agricola');
    }
}
