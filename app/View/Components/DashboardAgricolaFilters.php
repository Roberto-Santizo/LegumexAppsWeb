<?php

namespace App\View\Components;

use Closure;
use App\Models\Finca;
use Illuminate\View\Component;
use App\Models\PlanSemanalFinca;
use Illuminate\Contracts\View\View;

class DashboardAgricolaFilters extends Component
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
        $semanas = PlanSemanalFinca::select('semana')->distinct()->pluck('semana');
        return view('components.dashboard-agricola-filters', compact('fincas','semanas'));
    }
}
