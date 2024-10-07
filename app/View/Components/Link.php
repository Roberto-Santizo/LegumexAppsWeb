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
    public $params;

    // Acepta una lista variable de modelos
    public $models;

    /**
     * Create a new component instance.
     */
    public function __construct($route, $text = null, $icon = null, $params = [], ...$models)
    {
        $this->route = $route;
        $this->text = $text;
        $this->icon = $icon;
        $this->models = $models;
        $this->params = $params;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.link');
    }

    /**
     * Generate the URL with one or more models.
     */
    public function url()
{
    if (!empty($this->models)) {
        $params = array_map(function($model) {
            return is_object($model) ? $model->id : $model;
        }, $this->models);

        // Depuración
        dd($params, $this->params);

        return route($this->route, array_merge($params, $this->params));
    }

    return route($this->route, $this->params);
}
    
}
