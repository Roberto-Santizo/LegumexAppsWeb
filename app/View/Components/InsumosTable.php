<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InsumosTable extends Component
{
    public $insumos;
    /**
     * Create a new component instance.
     */
    public function __construct($insumos)
    {
        $this->insumos = $insumos;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.insumos-table');
    }
}
