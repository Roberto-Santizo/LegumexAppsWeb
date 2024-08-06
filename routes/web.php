<?php

use Illuminate\Auth\Events\Login;
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
use App\Http\Controllers\RegistroTemperaturasController;
use App\Http\Controllers\RendimientoRController;
use App\Http\Controllers\RoleController;

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
// Route::get('/administracion/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware(['auth']);

//Firmas
Route::post('/firmas',[FirmaController::class,'store'])->middleware('auth');

// Rutas con el prefijo '/administracion'
Route::group(['prefix' => 'mantenimiento', 'middleware' => ['auth', 'role:admin|adminmanto|auxmanto']], function () {
    
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.mantenimiento')->middleware(['auth']);
    // Mis ordenes
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

    Route::get('/registro-temperaturas', [RegistroTemperaturasController::class, 'index'])->name('registrostemp');
    Route::get('/registro-temperaturas/documento', [RegistroTemperaturasController::class, 'document'])->name('registrostemp.document');
});

// Rutas con el prefijo '/administracion' y middleware para adminmanto
Route::group(['prefix' => 'mantenimiento', 'middleware' => ['auth', 'role:admin|adminmanto']], function () {
    
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
Route::group(['middleware' => ['role:admin']],function(){
    //Usuarios
    Route::get('/administracion/usuarios', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('/administracion/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/administracion/usuarios/create', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::get('/administracion/usuarios/edit/{usuario:name}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::patch('/administracion/usuarios/update/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/administracion/usuarios/destroy/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

    //Roles
    Route::get('/administracion/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/administracion/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/administracion/roles/create', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/administracion/roles/edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/administracion/roles/update/{role}', [RoleController::class, 'update'])->name('roles.update');

    Route::get('/administracion/permisos', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/administracion/permisos/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/administracion/permisos/create', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/administracion/permisos/edit/{permission}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::patch('/administracion/permisos/update/{permission}', [PermissionController::class, 'update'])->name('permissions.update');

});


// //Reendimiento Reempaque
// Route::get('/rendimiento-reempaque',[RendimientoRController::class,'index'])->name('administracion.rendimiento.index');;


