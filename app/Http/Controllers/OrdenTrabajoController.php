<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estado;
use App\Models\Planta;
use App\Models\Supervisor;
use Microsoft\Graph\Graph;
use App\Models\OrdenTrabajo;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Services\MicrosoftTokenService;

class OrdenTrabajoController extends Controller 
{

    protected $tokenService;
    protected $EmailService;
    
    public function __construct(MicrosoftTokenService $tokenService, EmailService $EmailService)
    {
        $this->tokenService = $tokenService;
        $this->EmailService = $EmailService;
    }

    public function index()
    {
        $estados = Estado::whereIn('id',[1,2,3,4])->get();
        return view('mantenimiento.documentoOT.index', [
            'estados' => $estados
        ]);
    }

    public function create(){
        $plantas = Planta::all();
        $supervisores = Supervisor::all()->where('role_id',4)->where('status',1);
        return view('mantenimiento.documentoOT.create',['plantas' => $plantas, 'supervisores' => $supervisores]);
        
    }

    public function show(OrdenTrabajo $ordentrabajo){
        $user = auth()->user();
        // Verificar si el usuario es el mecánico asignado o un administrador
        if($ordentrabajo->estado_id == 1){
            if ($ordentrabajo->mecanico_id != $user->id && !$user->is_admin() && !$user->is_adminmanto()) {
                return redirect()->route('documentoOT')->with('error', 'No tienes permiso para acceder a esta orden de trabajo.');
            }  
        }else if($ordentrabajo->estado_id == 2){
            if (!$user->is_admin() && !$user->is_adminmanto()) {
                return redirect()->route('documentoOT')->with('error', 'No tienes permiso para acceder a esta orden de trabajo.');
            }
        }
        
        return view('mantenimiento.documentoOT.show',['ot' => $ordentrabajo]);
    }

    public function edit(OrdenTrabajo $ordentrabajo){
        $user = auth()->user();
        $supervisores = Supervisor::all()->where('role_id',5);
    
        // Verificar si el estado del documento es 1
            if ($ordentrabajo->estado_id == 1) {
                // Permitir acceso solo si el usuario es el mecánico asignado o un administrador
                if ($ordentrabajo->mecanico_id != $user->id && !$user->is_admin()) {
                    return redirect()->route('documentoOT')->with('error', 'No tienes permiso para editar esta orden de trabajo.');
                }
            } else if($ordentrabajo->estado_id == 2){
                // Si el estado del documento no es 1, solo permitir acceso a administradores
                if (!$user->is_adminmanto() && !$user->is_admin()) {
                    return redirect()->route('documentoOT')->with('error', 'No tienes permiso para editar esta orden de trabajo.');
                }
            }
        return view('mantenimiento.documentoOT.edit',['ot' => $ordentrabajo, 'supervisores' => $supervisores]);
    }

    public function update(OrdenTrabajo $ordentrabajo, Request $request)
    {
        try {
            DB::transaction(function () use ($request, $ordentrabajo) {
                $this->updateOrdenTrabajo($ordentrabajo, $request->all());
            });
    
            return redirect()->route('documentoOT')->with(['success' => 'La información fue guardada correctamente.']);
        } catch (\Throwable $th) {
        }
    }

    private function updateOrdenTrabajo(OrdenTrabajo $ordentrabajo, array $data)
    {
        // Campos que deben ser tratados como booleanos
        $booleanFields = [
            'devolucion_equipo', 
            'limpieza_equipo', 
            'orden_area', 
            'liberacion_trabajo'
        ];
    
        $updateData = [];
    
        foreach ($booleanFields as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = (bool)$data[$field];
            }
        }
    
        foreach ($data as $key => $value) {
            if (!is_null($value) && !in_array($key, $booleanFields)) {
                $updateData[$key] = $value;
            }
        }
    
        $ordentrabajo->update($updateData);
    }


    public function document(OrdenTrabajo $ordentrabajo){
        
        return view('mantenimiento.documentoOT.document',['ot' => $ordentrabajo]);
    }

    public function updateEstado(OrdenTrabajo $ordentrabajo, Request $request){
        $ordentrabajo->estado_id = 2;
        $ordentrabajo->save();

        return back();
    }

    public function consultarOT($planta,$area, $ubicacion,$estado){
        $ot = OrdenTrabajo::where('planta_id', $planta)
                            ->where('area_id', $area)
                            ->where('elemento_id', $ubicacion)
                            ->where('estado_id',$estado)
                            ->first();
        if($ot){
            return response()->json(['exists' => true, 'ot' => $ot],200);
        }else{
            return response()->json(['exists' => false],200);
        }
        
    }

    public function misOrdenes(){
        $misordenes = OrdenTrabajo::all()
            ->where('mecanico_id',auth()->user()->id)
            ->whereIn('estado_id',[1,6]);
        return view('mantenimiento.documentoOT.misordenes',['misordenes' => $misordenes]);
    }

    public function administrarOrdenes(){

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'auxmanto');
        })->paginate(4);
        $estados = Estado::all();

        return view('mantenimiento.documentoOT.administrar',[
            'estados' => $estados,
            'users' => $users
        ]);
    }

    public function OrdenesUsuario(Request $request, User $user){
        
        $ordenesUsuario = OrdenTrabajo::all()
                    ->where('mecanico_id',$user->id)
                    ->where('estado_id', 1);
        return view('mantenimiento.documentoOT.showUsuarioOrdenes',['usuario' => $user, 'ordenes' => $ordenesUsuario]);
    }

    public function showOrdenes(Estado $estado) {
    
        return view('mantenimiento.documentoOT.ordenes', [
            'titulo' => $estado->estado,
            'estado' => $estado,
        ]);
    }

    public function showEliminadas()
    {
        $ordenes = OrdenTrabajo::all()
                    ->where('estado_id',5);
                    
        return view('mantenimiento.documentoOT.showEliminadas',['ordenes' => $ordenes]);
    }

    public function showUrgencia(Request $request, $urgencia){
        $ordenes = OrdenTrabajo::all()
                            ->where('urgencia',$urgencia)
                            ->whereIn('estado_id', [1,2]);
        $titulo = ($urgencia == 1) ? 'Urgentes' : (($urgencia == 2) ? 'Importantes' : 'No importantes');
        return view('mantenimiento.documentoOT.showUrgencia',['ordenes' => $ordenes, 'titulo' => $titulo]);
    }
    
    public function store(Request $request){    
        try {

            $planta = Planta::findOrFail($request->planta_id);
            $ultimoCorrelativo = OrdenTrabajo::where('planta_id', $planta->id)->orderBy('created_at','DESC')->first();
            if ($ultimoCorrelativo) {
                $parts = explode('-', $ultimoCorrelativo);
                $numero = intval(end($parts));
                $nuevoNumero = $numero + 1;
            } else {
                $nuevoNumero = 1;
            }
            
            $orden_trabajo = OrdenTrabajo::create([
                'planta_id' => $request->planta_id,
                'area_id' => $request->area_id,
                'elemento_id' => $request->elemento_id,
                'nombre_solicitante' => ($request->nombre_solicitante) ?? auth()->user()->name,
                'firma_solicitante' => $request->firma_solicitante,
                'firma_supervisor' => $request->firma_supervisor,
                'equipo_problema' => $request->equipo_problema,
                'retiro_equipo' => $request->retiro_equipo,
                'fecha_propuesta' => $request->fecha_propuesta,
                'problema_detectado' => $request->problema_detectado,
                'urgencia' => $request->urgencia,
                'especifique' => $request->especifique,
                'estado_id' => 1,
                'supervisor_id' => $request->supervisor_id,
                'folder_url' => $request->folder_url,
                'folder_id' => $request->folder_id,
                'correlativo' => $planta->prefix . '-' . $nuevoNumero
            ]);

            $response = [
                'id' => $orden_trabajo->id,
                'ok' => true,
                'mensaje' => "Orden de trabajo creada correctamente",
                'status' => 200
            ];

            // $this->EmailService->sendNotificationNewOT($orden_trabajo);
            if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json($response, 200);
            } else {
                return redirect()->route('documentoOT')->with('success', $response['mensaje']);
            }

        } catch (\Throwable $th) { 
            $response = [
                'ok' => false,
                'status' => 500
            ];

            if ($request->ajax()) {
                return response()->json($response, 500);
            }else{
                return redirect()->route('documentoOT')->with('error',$th->getMessage());
            }
        }

    }

    public function uploadFile(Request $request){     
        try {
            $archivo = file_get_contents($request->file('file')->path());
            // Verifica si elobservaciones_eliminacion documento existe
            $ot = OrdenTrabajo::findOrFail($request->ot_id);
            $folder_id = $ot->planta->ot_folder_id;
            $accessToken = $this->tokenService->getValidAccessToken();
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            $response = $graph->createRequest('PUT', 'https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/' . $folder_id . ':/' . 'FOR-MN-04_' . $ot->correlativo . '.pdf:/content')
            ->addHeaders(['Content-Type' => 'application/pdf'])
            ->attachBody($archivo)
            ->execute();
            
            $responseBody = $response->getBody();
            $ot->update([
                'weburl' => $responseBody['webUrl'],
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

    public function destroy(OrdenTrabajo $ordentrabajo)
    {
        $response = Gate::inspect('delete',$ordentrabajo);

        if($response->allowed()){
            $ordentrabajo->estado_id = 5;
            $ordentrabajo->save();
            return back()->with('success','Orden de trabajo eliminada correctamente');
        }
        
    }

    public function rechazar(Request $request)
    {
        try{
            $ordentrabajo = OrdenTrabajo::findOrFail($request->id);
            $ordentrabajo->observaciones_eliminacion = $request->observaciones_eliminacion;
            $ordentrabajo->rechazada = 1;
            $ordentrabajo->estado_id = 1;
            $ordentrabajo->save();

            $reponse = [
                'mensaje' => 'Orden de trabajo rechazada correctamente',
                'status' => 200
            ];
            return response()->json($reponse,200);
        } catch(\Throwable $th){
            $reponse = [
                'status' => 500
            ];
            return response()->json($reponse,500);
        }
    }


}
