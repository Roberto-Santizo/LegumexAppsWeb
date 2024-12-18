<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tag extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;
    public $spanColor;

    public function __construct($label,$spanColor = null)
    {
        $this->label = $label;
        $this->spanColor = $spanColor ?? 'text-white';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tag');
    }
}
