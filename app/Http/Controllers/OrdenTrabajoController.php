<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Estado;
use App\Models\Planta;
use Microsoft\Graph\Graph;
use App\Models\Documentocp;
use App\Models\OrdenTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrdenTrabajoController extends Controller 
{

    public function index()
    {
        $estados = Estado::whereIn('id',[1,2,3,4])->get();
        return view('administracion.documentoOT.index', [
            'estados' => $estados
        ]);
    }

    public function create(){
        $plantas = Planta::all();
        return view('administracion.documentoOT.create',['plantas' => $plantas]);
        
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
        
        return view('administracion.documentoOT.show',['ot' => $ordentrabajo]);
    }

    public function edit(OrdenTrabajo $ordentrabajo){
        $user = auth()->user();
    
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
        return view('administracion.documentoOT.edit',['ot' => $ordentrabajo]);
    }

    public function update(OrdenTrabajo $ordentrabajo, Request $request)
    {
        try {
            DB::transaction(function () use ($request, $ordentrabajo) {
                $this->updateOrdenTrabajo($ordentrabajo, $request->all());
            });
    
            return redirect()->route('documentoOT')->with(['success' => 'La información fue guardada correctamente.']);
        } catch (\Throwable $th) {
            return back()->with('mensaje', 'Hubo un problema al guardar la información. Inténtelo de nuevo más tarde');
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
    
        // Preparar los datos a actualizar
        $updateData = [];
    
        // Procesar los campos booleanos
        foreach ($booleanFields as $field) {
            // Solo actualizar si el campo está presente en los datos
            if (array_key_exists($field, $data)) {
                $updateData[$field] = (bool)$data[$field];
            }
        }
    
        // Procesar otros campos
        foreach ($data as $key => $value) {
            if (!is_null($value) && !in_array($key, $booleanFields)) {
                $updateData[$key] = $value;
            }
        }
    
        // Realizar la actualización
        $ordentrabajo->update($updateData);
    }


    public function document(OrdenTrabajo $ordentrabajo){
        
        return view('administracion.documentoOT.document',['ot' => $ordentrabajo]);
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
        return view('administracion.documentoOT.misordenes',['misordenes' => $misordenes]);
    }

    public function administrarOrdenes(){

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'auxmanto');
        })->paginate(4);
        $estados = Estado::all();

        return view('administracion.documentoOT.administrar',[
            'estados' => $estados,
            'users' => $users
        ]);
    }

    public function OrdenesUsuario(Request $request, User $user){
        
        $ordenesUsuario = OrdenTrabajo::all()
                    ->where('mecanico_id',$user->id)
                    ->where('estado_id', 1);
        return view('administracion.documentoOT.showUsuarioOrdenes',['usuario' => $user, 'ordenes' => $ordenesUsuario]);
    }

    public function showOrdenes(Request $request, Estado $estado) {
        if($estado->id != 4){
            $query = OrdenTrabajo::where('estado_id', $estado->id)->latest();
        }else{
            $query = OrdenTrabajo::where('estado_id', 1) 
                        ->where('fecha_propuesta', '<', Carbon::now()->format('Y-m-d')) 
                        ->latest();
        }
    
        if ($request->filled('nombre_solicitante')) {
            $query->where('nombre_solicitante', 'like', '%' . $request->input('nombre_solicitante') . '%');
        }
    
        if ($request->filled('fecha_propuesta')) {
            $query->where('fecha_propuesta', $request->input('fecha_propuesta'));
        }

        if ($request->filled('planta_id')) {
            $query->where('planta_id', $request->input('planta_id'));
        }
        // Obtener resultados paginados
        $query->orderBy('created_at', 'desc');
        $ordenesTrabajo = $query->paginate(10)->appends($request->all());
        $plantas = Planta::all();
        
        return view('administracion.documentoOT.ordenes', [
            'ordenes' => $ordenesTrabajo,
            'filtro' => $request->search,
            'titulo' => $estado->estado,
            'estado' => $estado,
            'plantas' => $plantas
        ]);
    }

    public function showEliminadas()
    {
        $ordenes = OrdenTrabajo::all()
                    ->where('estado_id',5);
                    
        return view('administracion.documentoOT.showEliminadas',['ordenes' => $ordenes]);
    }

    public function showUrgencia(Request $request, $urgencia){
        $ordenes = OrdenTrabajo::all()
                            ->where('urgencia',$urgencia)
                            ->whereIn('estado_id', [1,2]);
        $titulo = ($urgencia == 1) ? 'Urgentes' : (($urgencia == 2) ? 'Importantes' : 'No importantes');
        return view('administracion.documentoOT.showUrgencia',['ordenes' => $ordenes, 'titulo' => $titulo]);
    }
    
    public function store(Request $request){       
        try {
            $orden_trabajo = OrdenTrabajo::create([
                'planta_id' => $request->planta_id,
                'area_id' => $request->area_id,
                'elemento_id' => $request->elemento_id,
                'nombre_solicitante' => auth()->user()->name,
                'firma_solicitante' => $request->firma_solicitante,
                'nombre_jefearea' => $request->nombre_jefearea,
                'firma_jefearea' => $request->firma_jefearea,
                'equipo_problema' => $request->equipo_problema,
                'retiro_equipo' => $request->retiro_equipo,
                'fecha_propuesta' => $request->fecha_propuesta,
                'problema_detectado' => $request->problema_detectado,
                'urgencia' => $request->urgencia,
                'especifique' => $request->especifique,
                'estado_id' => 1
            ]);

            $response = [
                'id' => $orden_trabajo->id,
                'ok' => true,
                'mensaje' => "Orden de trabajo creada correctamente",
                'status' => 200
            ];
            // Verificar si la solicitud es AJAX
            if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json($response, 200);
            } else {
                return redirect()->route('documentoOT')->with('success', $response['mensaje']);
            }

        } catch (\Throwable $th) { 
            $response = [
                'mensaje' => "Hubo un error al crear la orden de trabajo, vuelva a intentarlo",
                'ok' => false,
                'status' => 500
            ];

            if ($request->ajax()) {
                return response()->json($response, 500);
            } else {
                return back()->with('error', 'Hubo un error al guardar la orden de trabajo');
            }
        }

    }

    public function uploadFile(Request $request){     
        try {
            $archivo = file_get_contents($request->file('file')->path());
            // Verifica si elobservaciones_eliminacion documento existe
            $ot = OrdenTrabajo::findOrFail($request->ot_id);
            $accessToken = session('access_token');
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            $response = $graph->createRequest('PUT', 'https://graph.microsoft.com/v1.0/drives/b!CU_CMtvtaEmUlX3R-A80sL7OC60rTsBHt6CzRiilfLTCa6VHDHQGR6wIGs3pVZVG/items/01O5NWAPG373ZYCBRGSFFK5TO33HHQWMB3:/' . 'FOR-MN-04_' . $ot->id . '.pdf:/content')
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
                'mensaje' => 'Error al rechazar la orden de trabajo, intentelo de nuevo más tarde',
                'status' => 500
            ];
            return response()->json($reponse,500);
        }
    }


}
