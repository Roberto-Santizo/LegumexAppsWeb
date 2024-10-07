<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentoCPController;
use App\Http\Controllers\DocumentoLDController;
use App\Http\Controllers\HerramientasController;
use App\Http\Controllers\OrdenTrabajoController;

//Mantenimiento
Route::group(['middleware' => ['auth', 'role:admin|adminmanto|auxmanto'], 'prefix' => 'mantenimiento'], function() {
    
    // Herramientas
    Route::get('/herramientas', [HerramientasController::class, 'index'])->name('herramientas');
    Route::get('/herramientas/create', [HerramientasController::class, 'create'])->name('herramientas.create');
    Route::post('/herramientas/create', [HerramientasController::class, 'store'])->name('herramientas.store');
    Route::get('/herramientas/edit/{herramienta}', [HerramientasController::class, 'edit'])->name('herramientas.edit');
    Route::patch('/herramientas/update/{herramienta}', [HerramientasController::class, 'update'])->name('herramientas.update');
    Route::delete('/herramientas/{herramienta}', [HerramientasController::class, 'destroy'])->name('herramientas.destroy');
    
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
        Route::get('/documentocp/{planta:name}/create', [DocumentoCPController::class, 'create'])->name('documentocp.create');
        Route::post('/documentocp/{planta:name}/create', [DocumentoCPController::class, 'store'])->name('documentocp.store');
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
    
    Route::get('/administracion/ordenes-trabajos/{estado}',[OrdenTrabajoController::class,'showOrdenes'])->name('documentoOT.showordenes');

    Route::get('/administracion/ordenes-trabajos',[OrdenTrabajoController::class,'index'])->name('documentoOT');

    Route::get('/administracion/ordenes-trabajos/atrasadas',[OrdenTrabajoController::class,'showAtrasadas'])->name('documentoOT.showatrasadas');

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

});