<?php

namespace App\Http\Controllers;

use App\Models\Planta;
use Microsoft\Graph\Graph;
use App\Models\Documentocp;
use Illuminate\Http\Request;
use App\Models\OrdenChecklist;
use App\Models\AreasChecklistP;
use App\Models\AreasCPElementos;
use Illuminate\Support\Facades\DB;

class DocumentoCPController extends Controller
{
    public function index(Request $request)
    {
        $query = Documentocp::query();

        if ($request->filled('fecha')) {
            $query->where('fecha', 'like', '%' . $request->input('fecha') . '%');
        }

        if ($request->filled('planta_id')) {
            $query->where('planta_id', $request->input('planta_id'));
        }
        
        $query->orderBy('created_at', 'desc');

        $documentos = $query->paginate(5)->appends($request->all());
        $plantas = Planta::whereIn('id', [1, 2, 5])->get();
        return view('administracion.documentoCP.index', ['documentos' => $documentos, 'plantas' => $plantas]);
    }


    public function select()
    {
        $plantas = Planta::whereIn('id', [1,2,5])->get();
        return view('administracion.documentoCP.select', ['plantas' => $plantas]);
    }

    public function document(Documentocp $documentocp)
    {
        
        return view('administracion.documentoCP.document', ['documentocp' => $documentocp]);
    }


    public function create(Planta $planta)
    {
        return view('administracion.documentoCP.create', ['planta' => $planta]);
    }


    public function showOrdenesChecklist(Documentocp $documentocd)
    {
        $ordenes_checklist = $documentocd->ordenes;
        $ordenes = [];
        foreach ($ordenes_checklist as $orden) {
            if ($orden->orden->estado_id != 5) {
                $ordenes[] = $orden->orden;
            }
        }
        return view('administracion.documentoCP.showordenes', ['documento' => $documentocd, 'ordenes' => $ordenes]);
    }

    public function store(Planta $planta, Request $request)
    {
        $validated = $request->validate([
            'observaciones' => 'max:500',
            'verificado_firma' => 'required',
            'jefemanto_firma' => 'required',
            'supervisor_firma' => 'required',

        ]);

        try {
        DB::transaction(function () use ($request, $planta) {
        //Crear el documento principal
        $documentocp = Documentocp::create([
            'planta_id' => $planta->id,
            'fecha' => now()->format('d-m-Y'),
            'observaciones' => $request->observaciones,
            'verificado_firma' => $request->verificado_firma,
            'jefemanto_firma' => $request->jefemanto_firma,
            'supervisor_firma' => $request->supervisor_firma,
            'estado' => 1
        ]);

        // Preparar los datos para evitar registros duplicados
        $preparedData = [];
        foreach ($request->areas as $area => $cols) {
            foreach ($cols as $col => $elementos) {
                if ($col !== 'firma') { // Evitar que se incluya 'firma' en $preparedData
                    foreach ($elementos as $elemento => $valor) {
                        if (!isset($preparedData[$area][$elemento])) {
                            $preparedData[$area][$elemento] = [
                                'ok' => null,
                                'problema' => '',
                                'accion' => '',
                                'orden_trabajos_id' => null // Agregar el campo orden_trabajos_id aquí
                            ];
                        }
                        if ($col == 'ok') {
                            $preparedData[$area][$elemento]['ok'] = ($valor == 'on') ? 1 : 0;
                        } elseif ($col == 'problema') {
                            $preparedData[$area][$elemento]['problema'] = $valor;
                        } elseif ($col == 'accion') {
                            $preparedData[$area][$elemento]['accion'] = $valor;
                        } elseif ($col == 'orden_trabajos_id') {
                            $preparedData[$area][$elemento]['orden_trabajos_id'] = $valor;
                            if ($valor != null) {
                                OrdenChecklist::create([
                                    'documentocps_id' => $documentocp->id,
                                    'orden_trabajos_id' => $valor

                                ]);
                            }
                        }
                    }
                }
            }
        }

        //  Crear registros en la base de datos usando los datos preparados
        foreach ($request->areas as $area => $cols) {
            $documentocp_area = AreasChecklistP::create([
                'area_id' => $area,
                'documentocps_id' => $documentocp->id,
                'firma' => $cols['firma']
            ]);
            if (isset($preparedData[$area])) {
                foreach ($preparedData[$area] as $elemento => $data) {
                    AreasCPElementos::create([
                        'documentocp_area' => $documentocp_area->id,
                        'elemento_id' => $elemento,
                        'ok' => $data['ok'],
                        'problema' => $data['problema'],
                        'accion' => $data['accion'],
                        'orden_trabajos_id' => $data['orden_trabajos_id'], // Agregar este campo aquí
                    ]);
                }
            }
        }
        });

            return redirect()->route('documentocp')->with(['success' => 'Documento creado exitosamente']);
        } catch (\Throwable $th) {
            return back()->with('error', 'Hubo un problema al guardar el documento. Inténtelo de nuevo más tarde');
        }

    }

    public function uploadFile(Request $request)
    {
        
        try {
            $archivo = file_get_contents($request->file('file')->path());
            // Verifica si el documento existe
            $documentocp = Documentocp::findOrFail($request->documentocp_id);
           
            $accessToken = session('access_token');
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            $response = $graph->createRequest('PUT', 'https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/01O5NWAPDX5AFQJGS62BBK72PWLHYUY4KB:/' . 'FOR-MN-07_' . $documentocp->id . '.pdf:/content')
                ->addHeaders(['Content-Type' => 'application/pdf'])
                ->attachBody($archivo)
                ->execute();

            $responseBody = $response->getBody();

            $documentocp->update([
                'weburl' => $responseBody['webUrl'],
                'estado' => 2
            ]);

            $result = [
                'message' => 'Archivo guardado correctamente',
                'status' => 200

            ];

            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $reponse = [
                'mensaje' => 'mensaje',
                'status' => 500
            ];
            return response()->json($reponse, 500);
        }
    }
}
