<?php

namespace App\View\Components;

use Closure;
use App\Models\Planta;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class OrdenesTrabajoFilters extends Component
{
    /**
     * Create a new component instance.
     */
    public $plantas;

    public function __construct()
    {
        $this->plantas = Planta::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ordenes-trabajo-filters');
    }
}
