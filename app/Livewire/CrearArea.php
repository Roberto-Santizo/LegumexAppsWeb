<?php

namespace App\Livewire;

use App\Models\Area;
use App\Models\Planta;
use Livewire\Component;
use App\Models\Elemento;

class CrearArea extends Component
{
    public $plantas;
    public $ubicaciones = [];
    public $open = false;

    public $planta_id;
    public $area;

    protected $listeners = ['closeModal','guardarUbicacion','GuardarArea'];

    protected $rules = [
        'planta_id' => 'required',
        'area' => 'required'
    ];

    public function mount()
    {
        $this->plantas = Planta::all();
    }

    public function guardarUbicacion($datos)
    {
        $this->ubicaciones[] = $datos['ubicacion'];
        $this->closeModal();
    }

    public function openModal()
    {
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function GuardarArea()
    {
        $datos = $this->validate();
        if(count($this->ubicaciones) < 1)
        {
            $this->addError('ubicaciones','Debe agregar por lo menos un ubicación');
            return;
        }

        try {
            $area = Area::create([
                'area' => strtoupper($datos['area']),
                'planta_id' => $datos['planta_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $elementos = [];
            foreach ($this->ubicaciones as $ubicacion) {
                $elementos[] = [
                    'elemento' => strtoupper($ubicacion),
                    'area_id' => $area->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            Elemento::insert($elementos);
            
            return redirect()->route('areas')->with('success','Área creada Correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('areas')->with('error','Hubo un error al crear el área, intentelo de nuevo más tarde');
        }

    }
    public function render()
    {
        return view('livewire.crear-area');
    }
}
