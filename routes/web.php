<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UsuariosController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;


use App\Http\Controllers\DocumentoCPController;
use App\Http\Controllers\DocumentoLDController;
use App\Http\Controllers\HerramientasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MicrosoftAuthController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupervisoresController;

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
Route::get('/administracion/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware(['auth']);

//Firmas
Route::post('/firmas',[FirmaController::class,'store'])->middleware('auth');

//Mantenimiento
Route::group(['middleware' => ['auth','role:admin|adminmanto|auxmanto']],function(){

    //Herramientas
    Route::get('/administracion/herramientas',[HerramientasController::class,'index'])->name('herramientas');
    Route::get('/administracion/herramientas/create',[HerramientasController::class,'create'])->name('herramientas.create');
    Route::post('/administracion/herramientas/create',[HerramientasController::class,'store'])->name('herramientas.store');
    Route::get('/administracion/herramientas/edit/{herramienta}',[HerramientasController::class,'edit'])->name('herramientas.edit');
    Route::patch('/administracion/herramientas/update/{herramienta}',[HerramientasController::class,'update'])->name('herramientas.update');
    Route::delete('/administracion/herramientas/{herramienta}',[HerramientasController::class, 'destroy'])->name('herramientas.destroy');
    Route::get('/administracion/mis-ordenes',[OrdenTrabajoController::class,'misOrdenes'])->name('misOrdenes');

    //Lavado y desinfección
    Route::get('/administracion/documentold',[DocumentoLDController::class,'index'])->name('documentold');

    Route::middleware(['permission:create documentold'])->group(function () {
        Route::get('/administracion/documentold/create',[DocumentoLDController::class,'create'])->name('documentold.create');
        Route::post('/administracion/documentold/create',[DocumentoLDController::class,'store'])->name('documentold.store');
        Route::get('/administracion/documentold/{documentold}/edit', [DocumentoLDController::class, 'edit'])->name('documentold.edit');
        Route::patch('/administracion/documentold/{documentold}', [DocumentoLDController::class, 'update'])->name('documentold.update');
        Route::get('/administracion/documentold/generar-documento/{documentold}',[DocumentoLDController::class,'document'])->name('documentold.document');
        Route::post('/administracion/documentold/upload',[DocumentoLDController::class,'uploadFile'])->name('documentold.upload');
    });

    //Documento checklist preoperacional
    Route::get('/administracion/documentocp',[DocumentoCPController::class,'index'])->name('documentocp');;

    Route::middleware(['permission:create documentocp'])->group(function () {
        Route::get('/administracion/documentocp/select',[DocumentoCPController::class,'select'])->name('documentocp.select');
        Route::get('/administracion/documentocp/ordenes/{documentocd}',[DocumentoCPController::class,'showOrdenesChecklist'])->name('documentocp.showordeneschecklist');
        Route::get('/administracion/documentocp/{planta:name}/create',[DocumentoCPController::class,'create'])->name('documentocp.create');
        Route::post('/administracion/documentocp/{planta:name}/create',[DocumentoCPController::class,'store'])->name('documentocp.store');
        Route::get('/administracion/documentocp/generar-documento/{documentocp}',[DocumentoCPController::class,'document'])->name('documentocp.document');
        Route::post('/administracion/documentocp/upload',[DocumentoCPController::class,'uploadFile'])->name('documentocp.upload');
    });
    //Ordene de trabajo
    Route::middleware(['permission:create ot'])->group(function () {
        Route::get('/administracion/ordenes-trabajos/create',[OrdenTrabajoController::class,'create'])->name('documentoOT.create');
        Route::post('/administracion/ordenes-trabajos/store',[OrdenTrabajoController::class,'store'])->name('documentoOT.store');
        Route::get('/administracion/orden-trabajo/{ordentrabajo}',[OrdenTrabajoController::class,'show'])->name('documentoOT.show');
        Route::get('/administracion/orden-trabajo/generar-documento/{ordentrabajo}',[OrdenTrabajoController::class,'document'])->name('documentoOT.documento');
        Route::get('/administracion/orden-trabajo/{planta}/{area}/{ubicacion}/{estado}',[OrdenTrabajoController::class,'consultarOT'])->name('documentoOT.consultarOT');
        Route::get('/administracion/orden-trabajo/{ordentrabajo}/edit',[OrdenTrabajoController::class,'edit'])->name('documentoOT.edit');
        Route::patch('/administracion/orden-trabajo/{ordentrabajo}/estado',[OrdenTrabajoController::class,'updateEstado'])->name('documentoOT.updatestatus');
        Route::patch('/administracion/orden-trabajo/{ordentrabajo}',[OrdenTrabajoController::class,'update'])->name('documentoOT.update');
        Route::post('/administracion/orden-trabajo/upload',[OrdenTrabajoController::class,'uploadFile'])->name('documentoOT.upload');
    });

    Route::get('/administracion/ordenes-trabajos',[OrdenTrabajoController::class,'index'])->name('documentoOT');
    
    Route::get('/administracion/ordenes-trabajos/{estado:estado}',[OrdenTrabajoController::class,'showOrdenes'])->name('documentoOT.showordenes');

    Route::get('/administracion/ordenes-trabajos/atrasadas',[OrdenTrabajoController::class,'showAtrasadas'])->name('documentoOT.showatrasadas');

});

//Administrador Mantenimiento
Route::group(['middleware' => ['auth','role:admin|adminmanto']],function(){

    //Ordenes de trabajo
    Route::delete('/administracion/ordenes-trabajos/{ordentrabajo}',[OrdenTrabajoController::class, 'destroy'])->name('documentoOT.destroy');
    Route::get('/administracion/ordenes/eliminadas',[OrdenTrabajoController::class,'showEliminadas'])->name('documentoOT.showeliminadas');
    Route::get('/administracion/administrar/ordenes',[OrdenTrabajoController::class,'administrarOrdenes'])->name('administrar');
    Route::get('/administracion/ordenes-trabajos/administrar/{user:name}',[OrdenTrabajoController::class,'OrdenesUsuario'])->name('documentoOT.ordenesUsuario');
    Route::post('/administracion/orden-trabajo/rechazar',[OrdenTrabajoController::class,'rechazar'])->name('documentoOT.rechazar');
    Route::get('/administracion/ordenes-trabajos/urgencia/{urgencia}',[OrdenTrabajoController::class,'showUrgencia'])->name('documentoOT.showurgencia');
   

});

//Administrador
Route::group(['middleware' => ['role:admin']],function(){
    //Usuarios
    Route::get('/administracion/usuarios', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('/administracion/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/administracion/usuarios/create', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::get('/administracion/usuarios/edit/{usuario:name}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::patch('/administracion/usuarios/update/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/administracion/usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

    //Roles
    Route::get('/administracion/usuarios/roles', [RoleController::class, 'index'])->name('usuarios.roles');
    Route::get('/administracion/usuarios/roles/create', [RoleController::class, 'create'])->name('usuarios.roles-create');
    Route::post('/administracion/usuarios/roles/create', [RoleController::class, 'store'])->name('usuarios.roles-store');
    Route::get('/administracion/usuarios/roles/edit/{role}', [RoleController::class, 'edit'])->name('usuarios.roles-edit');
    Route::patch('/administracion/usuarios/roles/update/{role}', [RoleController::class, 'update'])->name('usuarios.roles-update');

    Route::get('/administracion/usuarios/permisos', [PermissionController::class, 'index'])->name('usuarios.permissions');
    Route::get('/administracion/usuarios/permisos/create', [PermissionController::class, 'create'])->name('usuarios.permissions-create');
    Route::post('/administracion/usuarios/permisos/create', [PermissionController::class, 'store'])->name('usuarios.permissions-store');
    Route::get('/administracion/usuarios/permisos/edit/{permission}', [PermissionController::class, 'edit'])->name('usuarios.permissions-edit');
    Route::patch('/administracion/usuarios/permisos/update/{permission}', [PermissionController::class, 'update'])->name('usuarios.permissions-update');

    Route::get('/administracion/usuarios/supervisores', [SupervisoresController::class, 'index'])->name('usuarios.supervisores');
    Route::get('/administracion/usuarios/supervisores/create', [SupervisoresController::class, 'create'])->name('usuarios.supervisores-create');
    Route::post('/administracion/usuarios/supervisores/create', [SupervisoresController::class, 'store'])->name('usuarios.supervisores-store');
    Route::get('/administracion/usuarios/supervisores/edit/{supervisor:name}', [SupervisoresController::class, 'edit'])->name('usuarios.supervisores-edit');
    Route::patch('/administracion/usuarios/supervisores/edit/{supervisor:name}', [SupervisoresController::class, 'update'])->name('usuarios.supervisores-update');
    Route::delete('/administracion/usuarios/supervisores/{supervisor}', [SupervisoresController::class, 'destroy'])->name('usuarios.supervisores-destroy');

});


// //Reendimiento Reempaque
// Route::get('/rendimiento-reempaque',[RendimientoRController::class,'index'])->name('administracion.rendimiento.index');;


