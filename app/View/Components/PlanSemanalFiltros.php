<?php

namespace App\View\Components;

use Closure;
use App\Models\Finca;
use Illuminate\View\Component;
use App\Models\PlanSemanalFinca;
use Illuminate\Contracts\View\View;

class PlanSemanalFiltros extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $fincas = Finca::all();
        $semanas = PlanSemanalFinca::all()->pluck('semana')->unique()->toArray();
        return view('components.plan-semanal-filtros',compact('fincas','semanas'));
    }
}
