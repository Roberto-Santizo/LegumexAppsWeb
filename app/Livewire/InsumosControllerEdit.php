<?php

namespace App\Livewire;

use Livewire\Component;

class InsumosControllerEdit extends Component
{
    public $insumo;
    public $code;
    public $insumoProp;

    protected $rules = [
        'insumo' => 'required',
        'code' => 'required'
    ];

    public function mount()
    {
        $this->insumo = $this->insumoProp->insumo;
        $this->code = $this->insumoProp->code;

    }
    public function update()
    {
        $datos = $this->validate();
        $this->insumoProp->insumo = $datos['insumo'];
        $this->insumoProp->code = $datos['code'];

        $this->insumoProp->save();

        return redirect()->route('insumos')->with('success','Insumo Editado Correctamente');
    }
    public function render()
    {
        return view('livewire.insumos-controller-edit');
    }
}
