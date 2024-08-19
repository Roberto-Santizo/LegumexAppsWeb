<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        return view('dashboards.index');
    }

    public function mantenimiento(){
        
        return view('dashboards.mantenimiento');
    }

    public function agricola(){
        
        return view('dashboards.agricola');
    }
}
