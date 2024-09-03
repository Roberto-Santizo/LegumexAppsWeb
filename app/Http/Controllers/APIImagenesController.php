<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Microsoft\Graph\Graph;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MicrosoftTokenService;
use Illuminate\Support\Facades\Storage;

class APIImagenesController extends Controller
{
    protected $tokenService;
    
    public function __construct(MicrosoftTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    public function store(Request $request)
    {
        $accessToken = $this->tokenService->getValidAccessToken();
        
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $datos = [];
        $folderId = $request->folder_id;
        
        if(!$request->folder_id){
            // Crear una carpeta en OneDrive (opcional)
            $folderName = uniqid() . '_' . Carbon::today()->format('d-m-Y');

            $createFolderResponse = $graph->createRequest('POST', "https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/01O5NWAPGP6Y6BDYV5GZGZ7INKQBPEWRGZ/children")
                ->attachBody([
                    'name' => $folderName,
                    'folder' => new \stdClass(),
                    '@microsoft.graph.conflictBehavior' => 'rename'
                ])
                ->execute();

            $folderId = $createFolderResponse->getBody()['id'];

            $datos['folder_id'] = $folderId;
            $datos['folder_url'] = $createFolderResponse->getBody()['webUrl'];
        }

        // Procesar y subir las imágenes
        foreach ($request->file() as $file) {
            // Verifica que el archivo sea una imagen
            if (in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                $fileName = uniqid() . '_' . Carbon::today()->format('d-m-Y') . '.png';
                $fileContent = file_get_contents($file->getRealPath());

                $graph->createRequest('PUT', "https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/{$folderId}:/$fileName:/content")
                    ->attachBody($fileContent)
                    ->execute();
            } else {
                return response()->json(['message' => 'Archivo no permitido'], 400);
            }
        }

        $datos['message'] = 'Las imagenes se han guardado correctamente';
        $datos['status'] = 200;

        return response()->json($datos,200);
    }


}
