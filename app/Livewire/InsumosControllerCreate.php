<?php

namespace App\Livewire;

use App\Models\Insumo;
use Livewire\Component;

class InsumosControllerCreate extends Component
{
    public $insumo;
    public $code;

    public $rules = [
        'insumo' => 'required',
        'code' => 'required',
    ];

    public function save()
    {
        $datos = $this->validate();
        Insumo::create([
            'insumo' => $datos['insumo'],
            'code' => $datos['code']
        ]);

        return redirect()->route('insumos')->with('success','Insumo creado correctamente');
    }
    public function render()
    {
        return view('livewire.insumos-controller-create');
    }
}
