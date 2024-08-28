<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Microsoft\Graph\Graph;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class APIImagenesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $accessToken = session('access_token');
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        // Crear una carpeta en OneDrive (opcional)
        $folderName = uniqid() . '_' . Carbon::today()->format('d-m-Y');

        $createFolderResponse = $graph->createRequest('POST', "/me/drive/root:/LegumexAppsWeb/Mantenimiento/UploadedImages:/children")
            ->attachBody([
                'name' => $folderName,
                'folder' => new \stdClass(),
                '@microsoft.graph.conflictBehavior' => 'rename'
            ])
            ->execute();

        $folderId = $createFolderResponse->getBody()['id'];

        // Procesar y subir las imágenes
        foreach ($request->file() as $file) {
            // Verifica que el archivo sea una imagen
            if (in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                $fileName = uniqid() . '_' . Carbon::today()->format('d-m-Y') . '.png';
                $fileContent = file_get_contents($file->getRealPath());

                $graph->createRequest('PUT', "/me/drive/items/{$folderId}:/$fileName:/content")
                    ->attachBody($fileContent)
                    ->execute();
            } else {
                return response()->json(['message' => 'Archivo no permitido'], 400);
            }
        }

        return response()->json(['folder_id' => $folderId,'folder_url' => $createFolderResponse->getBody()['webUrl'], 'status' => 200]);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
