<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardTareaHistoricoLote extends Component
{
    public $tarea;
    /**
     * Create a new component instance.
     */
    public function __construct($tarea)
    {
        $this->tarea = $tarea;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-tarea-historico-lote');
    }
}
