<?php

namespace App\View\Components;

use Closure;
use App\Models\Planta;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DocumentosLavadoFilter extends Component
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
        $plantas = Planta::all();
        return view('components.documentos-lavado-filter', compact(['plantas']));
    }
}
