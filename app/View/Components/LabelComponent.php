<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LabelComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;
    public $value;
    public $spanColor;

    public function __construct($label,$value,$spanColor = null)
    {
        $this->label = $label;
        $this->value = $value;
        $this->spanColor = $spanColor ?? 'text-black';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.label-component');
    }
}
