<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $label;
    public $options;
    public $selected;
    public $id;
    public $buscador;

    public function __construct($name, $label, $options = [], $selected = null, $id = '', $buscador = false)
    {
        $this->id = $id ?? $name;
        $this->name = $name;
        $this->label = $label;
        $this->options = $this->formatOptions($options);
        $this->selected = $selected;
        $this->buscador = $buscador;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }

    protected function formatOptions($options)
    {
        if ($options instanceof \Illuminate\Support\Collection) {
            // Assume it's a collection of models
            return $options->pluck('name', 'id')->toArray();
        }

        return $options;
    }
}
