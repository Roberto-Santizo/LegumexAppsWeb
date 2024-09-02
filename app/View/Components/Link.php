<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public $route;
    public $text;
    public $icon;
    public $model;
    public $params;

    /**
     * Create a new component instance.
     */
    public function __construct($route, $text = null , $icon = null,$model = null, $params = [])
    {
        $this->route = $route;
        $this->text = $text;
        $this->icon = $icon;
        $this->model = $model;
        $this->params = $params;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.link');
    }

    public function url()
    {
        if ($this->model) {
            return route($this->route, array_merge([$this->model], $this->params));
        }

        return route($this->route, $this->params);
    }
    
}
