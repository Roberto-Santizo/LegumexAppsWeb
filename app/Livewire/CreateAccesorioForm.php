<?php

namespace App\Livewire;

use App\Models\Accesorio;
use Livewire\Component;

class CreateAccesorioForm extends Component
{

    public $name;

    protected $rules = [
        'name' => 'required',
    ];


    public function save()
    {
        $datos = $this->validate();
        Accesorio::create([
            'name' => $datos['name']
        ]);

        return redirect()->route('equipos')->with('success','Accesorio Creado Correctamente');
    }
    public function render()
    {
        return view('livewire.create-accesorio-form');
    }
}
