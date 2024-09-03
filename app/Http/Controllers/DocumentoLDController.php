<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Planta;
use Microsoft\Graph\Graph;
use App\Models\Documentold;
use App\Models\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Services\MicrosoftTokenService;
use App\Models\Herramientas_documentold;

class DocumentoLDController extends Controller
{

    protected $tokenService;
    
    public function __construct(MicrosoftTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function index(Request $request){
        $query = Documentold::query();

        if ($request->filled('tecnico_mantenimiento')) {
            $query->where('tecnico_mantenimiento', 'like', '%' . $request->input('tecnico_mantenimiento') . '%');
        }

        if ($request->filled('fecha')) {
            $query->where('fecha', 'like', '%' . $request->input('fecha') . '%');
        }

        if ($request->filled('planta_id')) {
            $query->where('planta_id', $request->input('planta_id'));
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->input('area_id'));
        }

        $query->orderBy('created_at', 'desc');

        $documentosld = $query->paginate(10)->appends($request->all());
        $plantas = Planta::all();
        $areas = Area::all();
        return view('administracion.documentoLD.index',['documentos' => $documentosld, 'plantas' => $plantas, 'areas' => $areas]);
    }

    
    public function edit(Documentold $documentold){
        $documentold->fecha = Carbon::parse($documentold->fecha)->format('d/m/Y');
        return view('administracion.documentoLD.edit',['documento' => $documentold]);
    }

    public function create(){ 
        $plantas = Planta::all();
        $herramientas = Herramienta::all();
        return view('administracion.documentoLD.create',['plantas' => $plantas, 'herramientas' => $herramientas]);
    }

    public function document(Documentold $documentold){
        if($documentold->estado === 2){
            return redirect()->route('documentold')->with('mensaje','El documento ya ha sido generado');    
        }


        return view('administracion.documentoLD.document',['documentold' => $documentold, 'titulo' => 'Documento Lavado y Desinfección']);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'tecnico_mantenimiento' => 'required|max:125',
            'fecha' => 'required',
            'planta_id' => 'required',
            'area_id' => 'required',
            'entrada' => 'required', 
            'observaciones_entrada' => 'max:500', 
            'observaciones' => 'max:500', 
            'firma_entrada' => 'required', 
            'tecnico_firma' => 'required',
            'asistente_firma' => 'required'
        ]);

        try {
            DB::transaction(function () use ($request) {

                $documentold = Documentold::create([
                    'tecnico_mantenimiento' => $request->tecnico_mantenimiento,
                    'planta_id' => $request->planta_id,
                    'area_id' => $request->area_id,
                    'fecha' => $request->fecha,
                    'observaciones' => $request->observaciones,
                    'entrada' => $request->entrada,
                    'observaciones_entrada' => $request->observaciones_entrada,
                    'tecnico_firma' => $request->tecnico_firma,
                    'firma_entrada' => $request->firma_entrada,
                    'asistente_firma' => $request->asistente_firma,
                ]);
    
                $inserts = [];
                $herramientas = $request->herramientas;
    
                $herramientaIds = array_unique(array_merge(
                    $herramientas['lavadas']['si'] ?? [],
                    $herramientas['lavadas']['no'] ?? [],
                    $herramientas['desinfectadas']['si'] ?? [],
                    $herramientas['desinfectadas']['no'] ?? []
                ));
    
                foreach ($herramientaIds as $herramientaId) {
                    $inserts[] = [
                        'documentold_id' => $documentold->id,
                        'herramienta_id' => (int)$herramientaId,
                        'lavada_entrada' => in_array($herramientaId, $herramientas['lavadas']['si'] ?? []) ? true : (in_array($herramientaId, $herramientas['lavadas']['no'] ?? []) ? false : null),
                        'desinfectada_entrada' => in_array($herramientaId, $herramientas['desinfectadas']['si'] ?? []) ? true : (in_array($herramientaId, $herramientas['desinfectadas']['no'] ?? []) ? false : null)
                    ];
                }
    
               Herramientas_documentold::insert($inserts);
            });
            
        return redirect()->route('documentold')->with(['success' => 'Documento creado exitosamente']);
            
        } catch (\Throwable $th) { 
            return back()->with('mensaje', 'Hubo un problema al guardar el documento. Inténtelo de nuevo más tarde');
        }
    }

    public function update(Request $request, Documentold $documentold){
        
        $validated = $request->validate([
            'salida' => 'required',
            'observaciones_salida' => 'max:500',
            'firma_salida' => 'required',
            'inspector_firma' => 'required',
            
        ]);
        
        try {
            DB::transaction(function () use ($request, $documentold) {
                $documentold->update([
                    'salida' => $request->salida,
                    'observaciones_salida' => $request->observaciones_salida,
                    'inspector_firma' => $request->inspector_firma,
                    'firma_salida' => $request->firma_salida,
                    'observaciones' => $request->observaciones,
                    'estado' => 1
                ]);
    
                $herramientas = $request->herramientas;
    
                foreach ($documentold->herramientas as $herramienta) {
                    $aux1 = in_array($herramienta->herramienta->id, $herramientas['lavadas']['si'] ?? []) ? true : (in_array($herramienta->herramienta->id, $herramientas['lavadas']['no'] ?? []) ? false : null);
                    $aux2 = in_array($herramienta->herramienta->id, $herramientas['desinfectadas']['si'] ?? []) ? true : (in_array($herramienta->herramienta->id, $herramientas['desinfectadas']['no'] ?? []) ? false : null);
    
                    $herramienta->update([
                        'lavada_salida' => $aux1,
                        'desinfectada_salida' => $aux2
                    ]);
                }
            });
    
            return redirect()->route('documentold')->with(['success' => 'La información fue guardada correctamente']);
    
        } catch (\Throwable $th) {
            return back()->with('mensaje', 'Hubo un problema al guardar la información. Inténtelo de nuevo más tarde');
        }
    }

    public function uploadFile(Request $request)
    {  
        
        try {
            $archivo = file_get_contents($request->file('file')->path());
            // Verifica si el documento existe
            $documentold = DocumentoLD::findOrFail($request->documentold_id);
            
            $accessToken = $this->tokenService->getValidAccessToken();

            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            $response = $graph->createRequest('PUT', 'https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/01O5NWAPC5I5KSBVCQGVDIA5KTPW3RX63S:/' . 'FOR-MN-08_' . $documentold->id . '.pdf:/content')
            ->addHeaders(['Content-Type' => 'application/pdf'])
            ->attachBody($archivo)
            ->execute();
            
            $responseBody = $response->getBody();

            $documentold->update([
                'weburl' => $responseBody['webUrl'],
                'estado' => 2
            ]);

            $result = [
                'message' => 'Archivo guardado correctamente',
                'status' => 200
            
            ];

            return response()->json($result,200);
        } catch (\Throwable $th) {
            $reponse = [
                'mensaje' => 'mensaje',
                'status' => 500
            ];
            return response()->json($reponse,500);
        }

    }

}
