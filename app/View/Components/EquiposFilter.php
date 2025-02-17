<?php

namespace App\View\Components;

use App\Models\Planta;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EquiposFilter extends Component
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
        return view('components.equipos-filter');
    }
}
