<?php

namespace App\Livewire;

use App\Models\Accesorio;
use App\Models\Area;
use App\Models\Equipo;
use App\Models\EquipoAccesorios;
use Livewire\Component;

class EditEquipo extends Component
{
    public $accesorios_all;
    public $areas;
    public $equipo;

    public $accesorioIds = [];
    public $name;
    public $code;
    public $serie;
    public $modelo;
    public $acquisition_date;
    public $installation_date;
    public $area_id;

    protected $rules = [
        'name' => 'required',
        'code' => 'required',
        'area_id' => 'required',
    ];

    public function mount(Equipo $equipo)
    {
        $this->accesorios_all = Accesorio::all();
        $this->areas = Area::all();
        $this->equipo = $equipo;

        $this->name = $equipo->name;
        $this->code = $equipo->code;
        $this->serie = $equipo->serie;
        $this->modelo = $equipo->modelo;
        $this->acquisition_date = $equipo->acquisition_date ? $equipo->acquisition_date->format('Y-m-d') : null;
        $this->installation_date = $equipo->installation_date ? $equipo->installation_date->format('Y-m-d') : null;
        $this->area_id = $equipo->area_id;
        $this->accesorioIds = $equipo->accesorios->pluck('accesorio_id')->toArray();
    }


    public function save()
    {
        $data = $this->validate();

        try {
            $this->equipo->update([
                'name' => $data['name'],
                'code' => $data['code'],
                'serie' => $this->serie ?? null,
                'modelo' => $this->modelo ?? null,
                'acquisition_date' => $this->acquisition_date ?? null,
                'installation_date' => $this->installation_date ?? null,
                'area_id' => $data['area_id']
            ]); 

            $this->equipo->accesorios()->delete();

            if (count($this->accesorioIds) > 0) {
                foreach ($this->accesorioIds as $accesorio) {
                    $accesorio = Accesorio::find($accesorio);
                    EquipoAccesorios::create([
                        'accesorio_id' => $accesorio->id,
                        'equipo_id' => $this->equipo->id
                    ]);
                }
            }

            return redirect()->route('equipos')->with('success', 'Equipo Editado Correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('equipos')->with('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.edit-equipo');
    }
}
