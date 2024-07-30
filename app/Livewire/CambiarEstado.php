<?php

namespace App\Livewire;

use Livewire\Component;

class CambiarEstado extends Component
{
    public $post;
    
    public function render()
    {
        return view('livewire.cambiar-estado');
    }
}
