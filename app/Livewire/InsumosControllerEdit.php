<?php

namespace App\Livewire;

use Livewire\Component;

class InsumosControllerEdit extends Component
{
    public $insumo;
    public $code;
    public $medida;
    public $insumoProp;

    protected $rules = [
        'insumo' => 'required',
        'code' => 'required',
        'medida'=> 'required'
    ];

    public function mount()
    {
        $this->insumo = $this->insumoProp->insumo;
        $this->code = $this->insumoProp->code;
        $this->medida = $this->insumoProp->medida;

    }
    public function update()
    {
        $datos = $this->validate();
        $this->insumoProp->insumo = $datos['insumo'];
        $this->insumoProp->code = $datos['code'];
        $this->insumoProp->medida = $datos['medida'];

        $this->insumoProp->save();

        return redirect()->route('insumos')->with('success','Insumo Editado Correctamente');
    }
    public function render()
    {
        return view('livewire.insumos-controller-edit');
    }
}
