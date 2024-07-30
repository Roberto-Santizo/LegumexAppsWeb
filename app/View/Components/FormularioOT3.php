<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormularioOT3 extends Component
{
    public $ot;
    public function __construct($ot)
    {
        $this->ot = $ot;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.formulario-o-t3');
    }
}
