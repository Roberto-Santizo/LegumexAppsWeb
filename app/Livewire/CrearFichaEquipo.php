<?php

namespace App\Livewire;

use App\Models\Accesorio;
use App\Models\Area;
use App\Models\Equipo;
use App\Models\EquipoAccesorios;
use App\Services\MicrosoftTokenService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Microsoft\Graph\Graph;

class CrearFichaEquipo extends Component
{

    public $accesorios_all;
    public $areas;


    public $accesorios = [];
    public $name;
    public $code;
    public $serie;
    public $modelo;
    public $acquisition_date;
    public $installation_date;
    public $area_id;


    public $imagenes = [];

    use WithFileUploads;

    protected $rules = [
        'name' => 'required',
        'code' => 'required',
        'area_id' => 'required',
        'imagenes.*' => 'image|mimes:jpeg,png|max:2048'
    ];

    public function mount()
    {
        $this->accesorios_all = Accesorio::all();
        $this->areas = Area::all();
    }

    public function save()
    {
        $data = $this->validate();
        try {
            $tokenService = new MicrosoftTokenService;
            $accessToken = $tokenService->getValidAccessToken();
            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            $folderName = uniqid() . '_' . Carbon::today()->format('d-m-Y');
            $createFolderResponse = $graph->createRequest('POST', "https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/01O5NWAPGP6Y6BDYV5GZGZ7INKQBPEWRGZ/children")
                ->attachBody([
                    'name' => $folderName,
                    'folder' => new \stdClass(),
                    '@microsoft.graph.conflictBehavior' => 'rename'
                ])
                ->execute();

            $folderId = $createFolderResponse->getBody()['id'];
            $folderUrl = $createFolderResponse->getBody()['webUrl'];

            foreach ($this->imagenes as $file) {
                $fileName = uniqid() . '_' . Carbon::today()->format('d-m-Y') . '.png';
                $fileContent = file_get_contents($file->getRealPath());
                $graph->createRequest('PUT', "https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/{$folderId}:/$fileName:/content")
                    ->attachBody($fileContent)
                    ->execute();
            }

            $equipo = Equipo::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'area_id' => $data['area_id'],
                'serie' => $this->serie,
                'modelo' => $this->modelo,
                'acquisition_date' => $this->acquisition_date,
                'installation_date' => $this->installation_date,
                'folder_url' => $folderUrl
            ]);

            if (count($this->accesorios) > 0) {
                foreach ($this->accesorios as $accesorio) {
                    $accesorio = Accesorio::find($accesorio);
                    EquipoAccesorios::create([
                        'accesorio_id' => $accesorio->id,
                        'equipo_id' => $equipo->id
                    ]);
                }
            }

            return redirect()->route('equipos')->with('success', 'Equipo Creado Correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('equipos')->with('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.crear-ficha-equipo');
    }
}
