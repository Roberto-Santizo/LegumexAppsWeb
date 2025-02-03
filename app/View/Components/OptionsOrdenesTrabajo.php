<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OptionsOrdenesTrabajo extends Component
{
    /**
     * Create a new component instance.
     */
    public $ot;
    public $priority;

    public function __construct($ot)
    {
        $priorities = [
            1 => 'text-red-500',
            2 => 'text-yellow-500',
            3 => 'text-green-500',
            "" => 'text-black'
        ];
        $this->ot = $ot;
        $this->priority = $priorities[$ot->urgencia];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.options-ordenes-trabajo');
    }
}
