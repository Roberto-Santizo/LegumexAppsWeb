<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\FirmaController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DocumentoCPController;
use App\Http\Controllers\DocumentoLDController;
use App\Http\Controllers\TareasFincaController;
use App\Http\Controllers\HerramientasController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\RendimientoRController;
use App\Http\Controllers\SupervisoresController;
use App\Http\Controllers\MicrosoftAuthController;
use App\Http\Controllers\ControlPlantacionController;
use App\Http\Controllers\PlanSemanalFincasController;

//Página Principal
Route::get('/', HomeController::class)->name('home');

//Autenticación
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'store']);
Route::post('/logout/user',[LogoutController::class,'store'])->name('logout');

//Autenticación microsoft
Route::get('/login/microsoft',[MicrosoftAuthController::class,'redirectToMicrosoft'])->name('redirectToMicrosoft');
Route::get('/login/microsoft/callback',[MicrosoftAuthController::class,'handleMicrosoftCallback'])->name('handleMicrosoftCallback');
Route::post('/logout',[MicrosoftAuthController::class,'logout'])->name('logout.microsoft');
Route::get('/post-logout', [MicrosoftAuthController::class, 'postLogout'])->name('post-logout');

//Dashboard Principal
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware(['auth']);

//Firmas
Route::post('/firmas',[FirmaController::class,'store'])->middleware('auth');

//Mantenimiento
Route::group(['middleware' => ['auth', 'role:admin|adminmanto|auxmanto'], 'prefix' => 'mantenimiento'], function() {
    
    Route::get('/mis-ordenes', [OrdenTrabajoController::class, 'misOrdenes'])->name('misOrdenes');

    // Lavado y desinfección
    Route::get('/documentold', [DocumentoLDController::class, 'index'])->name('documentold');

    Route::middleware(['permission:create documentold'])->group(function () {
        Route::get('/documentold/create', [DocumentoLDController::class, 'create'])->name('documentold.create');
        Route::post('/documentold/create', [DocumentoLDController::class, 'store'])->name('documentold.store');
        Route::get('/documentold/{documentold}/edit', [DocumentoLDController::class, 'edit'])->name('documentold.edit');
        Route::patch('/documentold/{documentold}', [DocumentoLDController::class, 'update'])->name('documentold.update');
        Route::get('/documentold/generar-documento/{documentold}', [DocumentoLDController::class, 'document'])->name('documentold.document');
        Route::post('/documentold/upload', [DocumentoLDController::class, 'uploadFile'])->name('documentold.upload');
    });

    // Documento checklist preoperacional
    Route::get('/documentocp', [DocumentoCPController::class, 'index'])->name('documentocp');

    Route::middleware(['permission:create documentocp'])->group(function () {
        Route::get('/documentocp/select', [DocumentoCPController::class, 'select'])->name('documentocp.select');
        Route::get('/documentocp/ordenes/{documentocd}', [DocumentoCPController::class, 'showOrdenesChecklist'])->name('documentocp.showordeneschecklist');
        Route::get('/documentocp/{planta:planta}/create', [DocumentoCPController::class, 'create'])->name('documentocp.create');
        Route::post('/documentocp/{planta:planta}/create', [DocumentoCPController::class, 'store'])->name('documentocp.store');
        Route::get('/documentocp/generar-documento/{documentocp}', [DocumentoCPController::class, 'document'])->name('documentocp.document');
        Route::post('/documentocp/upload', [DocumentoCPController::class, 'uploadFile'])->name('documentocp.upload');
    });

    // Ordenes de trabajo
    Route::middleware(['permission:create ot'])->group(function () {
        Route::get('/ordenes-trabajos/create', [OrdenTrabajoController::class, 'create'])->name('documentoOT.create');
        Route::post('/ordenes-trabajos/store', [OrdenTrabajoController::class, 'store'])->name('documentoOT.store');
        Route::get('/orden-trabajo/{ordentrabajo}', [OrdenTrabajoController::class, 'show'])->name('documentoOT.show');
        Route::get('/orden-trabajo/generar-documento/{ordentrabajo}', [OrdenTrabajoController::class, 'document'])->name('documentoOT.documento');
        Route::get('/orden-trabajo/{planta}/{area}/{ubicacion}/{estado}', [OrdenTrabajoController::class, 'consultarOT'])->name('documentoOT.consultarOT');
        Route::get('/orden-trabajo/{ordentrabajo}/edit', [OrdenTrabajoController::class, 'edit'])->name('documentoOT.edit');
        Route::patch('/orden-trabajo/{ordentrabajo}/estado', [OrdenTrabajoController::class, 'updateEstado'])->name('documentoOT.updatestatus');
        Route::patch('/orden-trabajo/{ordentrabajo}', [OrdenTrabajoController::class, 'update'])->name('documentoOT.update');
        Route::post('/orden-trabajo/upload', [OrdenTrabajoController::class, 'uploadFile'])->name('documentoOT.upload');
    });

    Route::get('/ordenes-trabajos', [OrdenTrabajoController::class, 'index'])->name('documentoOT');
    Route::get('/ordenes-trabajos/{estado:estado}', [OrdenTrabajoController::class, 'showOrdenes'])->name('documentoOT.showordenes');
    Route::get('/ordenes-trabajos/atrasadas', [OrdenTrabajoController::class, 'showAtrasadas'])->name('documentoOT.showatrasadas');

});


//Administrador Mantenimiento
Route::group(['middleware' => ['auth', 'role:admin|adminmanto'], 'prefix' => 'mantenimiento'], function() {

    // Ordenes de trabajo
    Route::delete('/ordenes-trabajos/{ordentrabajo}', [OrdenTrabajoController::class, 'destroy'])->name('documentoOT.destroy');
    Route::get('/ordenes/eliminadas', [OrdenTrabajoController::class, 'showEliminadas'])->name('documentoOT.showeliminadas');
    Route::get('/administrar/ordenes', [OrdenTrabajoController::class, 'administrarOrdenes'])->name('administrar');
    Route::get('/ordenes-trabajos/administrar/{user:name}', [OrdenTrabajoController::class, 'OrdenesUsuario'])->name('documentoOT.ordenesUsuario');
    Route::post('/orden-trabajo/rechazar', [OrdenTrabajoController::class, 'rechazar'])->name('documentoOT.rechazar');
    Route::get('/ordenes-trabajos/urgencia/{urgencia}', [OrdenTrabajoController::class, 'showUrgencia'])->name('documentoOT.showurgencia');

    // Herramientas
    Route::get('/herramientas', [HerramientasController::class, 'index'])->name('herramientas');
    Route::get('/herramientas/create', [HerramientasController::class, 'create'])->name('herramientas.create');
    Route::post('/herramientas/create', [HerramientasController::class, 'store'])->name('herramientas.store');
    Route::get('/herramientas/edit/{herramienta}', [HerramientasController::class, 'edit'])->name('herramientas.edit');
    Route::patch('/herramientas/update/{herramienta}', [HerramientasController::class, 'update'])->name('herramientas.update');
    Route::delete('/herramientas/{herramienta}', [HerramientasController::class, 'destroy'])->name('herramientas.destroy');

});


//Administrador
Route::group(['middleware' => ['role:admin'], 'prefix' => 'administracion/usuarios'], function() {
    //Usuarios
    Route::get('/', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('/create', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/create', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::get('/edit/{usuario:name}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::patch('/update/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('usuarios.roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('usuarios.roles-create');
    Route::post('/roles/create', [RoleController::class, 'store'])->name('usuarios.roles-store');
    Route::get('/roles/edit/{role}', [RoleController::class, 'edit'])->name('usuarios.roles-edit');
    Route::patch('/roles/update/{role}', [RoleController::class, 'update'])->name('usuarios.roles-update');

    //Permisos
    Route::get('/permisos', [PermissionController::class, 'index'])->name('usuarios.permissions');
    Route::get('/permisos/create', [PermissionController::class, 'create'])->name('usuarios.permissions-create');
    Route::post('/permisos/create', [PermissionController::class, 'store'])->name('usuarios.permissions-store');
    Route::get('/permisos/edit/{permission}', [PermissionController::class, 'edit'])->name('usuarios.permissions-edit');
    Route::patch('/permisos/update/{permission}', [PermissionController::class, 'update'])->name('usuarios.permissions-update');

    //Supervisores
    Route::get('/supervisores', [SupervisoresController::class, 'index'])->name('usuarios.supervisores');
    Route::get('/supervisores/create', [SupervisoresController::class, 'create'])->name('usuarios.supervisores-create');
    Route::post('/supervisores/create', [SupervisoresController::class, 'store'])->name('usuarios.supervisores-store');
    Route::get('/supervisores/edit/{supervisor:name}', [SupervisoresController::class, 'edit'])->name('usuarios.supervisores-edit');
    Route::patch('/supervisores/edit/{supervisor:name}', [SupervisoresController::class, 'update'])->name('usuarios.supervisores-update');
    Route::delete('/supervisores/{supervisor}', [SupervisoresController::class, 'destroy'])->name('usuarios.supervisores-destroy');
});

Route::group(['middleware' => ['auth', 'role:admin|adminalameda|auxalameda'], 'prefix' => 'agricola'], function() {
    
    //Cultivos
    Route::get('/cultivos', [CultivoController::class, 'index'])->name('cultivos');
    Route::get('/cultivos/create', [CultivoController::class, 'create'])->name('cultivos.create');
    Route::get('/cultivos/edit/{cultivo:cultivo}', [CultivoController::class, 'edit'])->name('cultivos.edit');
    Route::post('/cultivos/create', [CultivoController::class, 'store'])->name('cultivos.store');
    Route::patch('/cultivos/update/{cultivo}', [CultivoController::class, 'update'])->name('cultivos.update');

    //Tareas
    Route::get('/tareas', [TareasController::class, 'index'])->name('tareas');
    Route::get('/tareas/create', [TareasController::class, 'create'])->name('tareas.create');
    Route::get('/tareas/edit/{tarea:tarea}', [TareasController::class, 'edit'])->name('tareas.edit');
    Route::get('/tareas/show/{tarea}', [TareasController::class, 'show'])->name('tareas.show');
    Route::get('/tareas/historial', [TareasController::class, 'historial'])->name('tareas.historial');
    Route::post('/tareas/create', [TareasController::class, 'store'])->name('tareas.store');
    Route::patch('/tareas/update/{tarea}', [TareasController::class, 'update'])->name('tareas.update');

    //CDP's
    Route::get('/cdps', [ControlPlantacionController::class, 'index'])->name('cdps');
    Route::get('/cdps/create', [ControlPlantacionController::class, 'create'])->name('cdps.create');
    Route::post('/cdps/create', [ControlPlantacionController::class, 'store'])->name('cdps.store');

    //Lotes
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes');
    Route::get('/lotes/create', [LoteController::class, 'create'])->name('lotes.create');
    Route::get('/lotes/edit/{lote}', [LoteController::class, 'edit'])->name('lotes.edit');
    Route::get('/lotes/historial', [LoteController::class, 'historial'])->name('lotes.historial');
    Route::post('/lotes/create', [LoteController::class, 'store'])->name('lotes.store');
    Route::patch('/lotes/update/{lote}', [LoteController::class, 'update'])->name('lotes.update');
    Route::delete('/{lote}', [LoteController::class, 'destroy'])->name('lotes.destroy');

    //Tareas Fincas
    Route::get('/finca/plan-semanal', [PlanSemanalFincasController::class, 'index'])->name('planSemanal');
    Route::get('/finca/plan-semanal/create', [PlanSemanalFincasController::class, 'create'])->name('planSemanal.create');
    Route::get('/finca/plan-semanal/plan-{plansemanalfinca}/lotes', [PlanSemanalFincasController::class, 'show'])->name('planSemanal.show');
    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/tareas', [PlanSemanalFincasController::class, 'tareasLote'])->name('planSemanal.tareasLote');
    Route::post('/finca/plan-semanal/create', [PlanSemanalFincasController::class, 'store'])->name('planSemanal.store');
});





// //Reendimiento Reempaque
// Route::get('/rendimiento-reempaque',[RendimientoRController::class,'index'])->name('administracion.rendimiento.index');;


