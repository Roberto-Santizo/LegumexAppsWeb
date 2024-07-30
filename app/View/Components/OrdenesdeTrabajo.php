<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrdenesdeTrabajo extends Component
{
    public $ots;
    public function __construct($ots)
    {
        $this->ots = $ots;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ordenesde-trabajo');
    }
}
