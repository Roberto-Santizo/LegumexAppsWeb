<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoteController;

use App\Http\Controllers\TareasController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuariosFincaController;
use App\Http\Controllers\AsignacionDiariaController;
use App\Http\Controllers\ControlPlantacionController;
use App\Http\Controllers\PlanSemanalFincasController;
use App\Http\Controllers\TareaLoteController;

Route::group(['middleware' => ['auth', 'role:admin|adminagricola|auxalameda'], 'prefix' => 'agricola'], function() {
    
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
    
    //Plan semanal (tareas fincas)
    Route::get('/finca/plan-semanal', [PlanSemanalFincasController::class, 'index'])->name('planSemanal');
    Route::get('/finca/plan-semanal/create', [PlanSemanalFincasController::class, 'create'])->name('planSemanal.create');
    Route::get('/finca/plan-semanal/plan-{plansemanalfinca}/lotes', [PlanSemanalFincasController::class, 'show'])->name('planSemanal.show');
    Route::get('/finca/plan-semanal/plan-{plansemanalfinca}/atrasadas', [PlanSemanalFincasController::class, 'atrasadas'])->name('planSemanal.atrasadas');

    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/tareas', [PlanSemanalFincasController::class, 'tareasLote'])->name('planSemanal.tareasLote');
    

    Route::get('/tarea-lote/{lote:nombre}/plan-{plansemanalfinca}/create', [TareaLoteController::class, 'create'])->name('planSemanal.tareaLote.create');
    Route::get('/tarea-lote/{tareaslote}/edit', [TareaLoteController::class, 'edit'])->name('planSemanal.tareaLote.edit');
    
    Route::post('/tarea-lote/store/{lote}/{plansemanalfinca}', [TareaLoteController::class, 'store'])->name('planSemanal.tareaLote.store');
    
    
    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/tareas/ctr', [PlanSemanalFincasController::class, 'crt'])->name('planSemanal.crt');
    Route::get('/finca/plan-semanal/lotes/{lote:nombre}/{plansemanalfinca}/{tarea}/{tarealote}/asignacion', [PlanSemanalFincasController::class, 'AsignarEmpleados'])->name('planSemanal.Asignar');


    Route::get('/finca/plan-semanal/rendimiento/tarea-{tarealote}/plan-{plansemanalfinca}', [PlanSemanalFincasController::class, 'rendimiento'])->name('planSemanal.rendimiento');
    
    Route::get('/finca/plan-semanal/rendimiento/{usuario}/tarea-{tarealote}/create', [PlanSemanalFincasController::class, 'diario'])->name('planSemanal.diario');
    
    Route::post('/finca/plan-semanal/rendimiento/store', [PlanSemanalFincasController::class, 'storeDiario'])->name('planSemanal.storediario');

    Route::post('/finca/plan-semanal/create', [PlanSemanalFincasController::class, 'store'])->name('planSemanal.store');


    //Asignacion Diaria
    Route::post('/finca/plan-semanal/create/{lote}/{plansemanalfinca}', [AsignacionDiariaController::class, 'store'])->name('asignacionDiaria.store');

    //Usuarios Fincas
    Route::get('/finca/ingresos', [UsuariosFincaController::class, 'index'])->name('usuariosFincas');

    // Reporteria
    Route::get('/exportar-plansemanal/{id}', [ReporteController::class, 'PlanSemanalDiario'])->name('reporte.PlanSemanalDiario');
    


});