<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Microsoft\Graph\Graph;
use Illuminate\Http\Request;
use App\Services\MicrosoftTokenService;
use Microsoft\Graph\Exception\GraphException;

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

        if (!$folderId) {
            // Crear una carpeta en OneDrive
            try {
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
            } catch (GraphException $e) {
                return response()->json(['message' => 'Error al crear la carpeta: ' . $e->getMessage()], 500);
            }
        }

        // Procesar y subir las imágenes
        foreach ($request->file() as $file) {
            if (in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                $fileName = uniqid() . '_' . Carbon::today()->format('d-m-Y') . '.png';
                $fileContent = file_get_contents($file->getRealPath());

                try {
                    $graph->createRequest('PUT', "https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/{$folderId}:/$fileName:/content")
                        ->attachBody($fileContent)
                        ->execute();
                } catch (GraphException $e) {
                    return response()->json(['message' => 'Error al subir la imagen: ' . $e->getMessage()], 500);
                }
            } else {
                return response()->json(['message' => 'Archivo no permitido'], 400);
            }
        }

        $datos['message'] = 'Las imágenes se han guardado correctamente';
        $datos['status'] = 200;
        return response()->json($datos, 200);
    }



}
