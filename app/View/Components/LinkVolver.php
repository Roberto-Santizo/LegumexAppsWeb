<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkVolver extends Component
{
    public $ruta;
    public $parametros;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ruta, $parametros = [])
    {
        $this->ruta = $ruta;
        $this->parametros = $parametros;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.link-volver');
    }
}

