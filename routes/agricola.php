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
use App\Http\Controllers\TareaCosechaLoteController;
use App\Http\Controllers\TareaLoteController;

Route::group(['middleware' => ['auth', 'role:admin|adminagricola|auxalameda'], 'prefix' => 'agricola'], function() {
    Route::get('/finca/plan-semanal/lotes/{lote:nombre}/{plansemanalfinca}/{tarea}/{tarealotecosecha}/cosecha/asignacion', [PlanSemanalFincasController::class, 'AsignarEmpleadosCosecha'])->name('planSemanal.AsignarEmpleadosCosecha');

    //Plan semanal (tareas fincas)
    Route::get('/finca/plan-semanal', [PlanSemanalFincasController::class, 'index'])->name('planSemanal');
    Route::get('/finca/plan-semanal/plan-{plansemanalfinca}/lotes', [PlanSemanalFincasController::class, 'show'])->name('planSemanal.show');
    Route::get('/finca/plan-semanal/plan-{plansemanalfinca}/atrasadas', [PlanSemanalFincasController::class, 'atrasadas'])->name('planSemanal.atrasadas');

    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/tareas', [PlanSemanalFincasController::class, 'tareasLote'])->name('planSemanal.tareasLote');
    
    Route::get('/finca/plan-semanal/lotes/{lote:nombre}/{plansemanalfinca}/{tarea}/{tarealote}/asignacion', [PlanSemanalFincasController::class, 'AsignarEmpleados'])->name('planSemanal.Asignar');

    //Asignacion Diaria
    Route::post('/finca/plan-semanal/create/{lote}/{plansemanalfinca}', [AsignacionDiariaController::class, 'store'])->name('asignacionDiaria.store');

    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/cosecha/tareas', [PlanSemanalFincasController::class, 'tareasCosechaLote'])->name('planSemanal.tareasCosechaLote');
    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/cosecha/{tarealotecosecha}/rendimiento', [PlanSemanalFincasController::class, 'tareasCosechaLoteRendimiento'])->name('planSemanal.tareasCosechaLoteRendimiento');


});

Route::group(['middleware' => ['auth', 'role:admin|adminagricola'], 'prefix' => 'agricola'], function() {
    Route::get('/finca/plan-semanal/create', [PlanSemanalFincasController::class, 'create'])->name('planSemanal.create'); 

    Route::get('/finca/plan-semanal/lotes/{lote}/{plansemanalfinca}/cosecha/{tarealotecosecha}/rendimiento/real', [PlanSemanalFincasController::class, 'tareasCosechaLoteRendimientoReal'])->name('planSemanal.tareasCosechaLoteRendimiento.real');
    Route::get('/finca/plan-semanal/cosecha-{tarealotecosecha}/resumen', [TareaCosechaLoteController::class, 'tareaCosechaResumen'])->name('planSemanal.tareaCosechaResumen');
    
    
    Route::get('/tarea/create', [TareasController::class, 'create'])->name('tareas.create');
    Route::get('/tarea/carga', [TareasController::class, 'carga'])->name('tareas.carga');
    Route::post('/tarea/import', [TareasController::class, 'import'])->name('tareas.import');

    Route::get('/tareas/edit/{tarea:tarea}', [TareasController::class, 'edit'])->name('tareas.edit');
    Route::get('/tareas/show/{tarea}', [TareasController::class, 'show'])->name('tareas.show');
    Route::get('/tareas/historial', [TareasController::class, 'historial'])->name('tareas.historial');
    Route::post('/tareas/create', [TareasController::class, 'store'])->name('tareas.store');
    Route::patch('/tareas/update/{tarea}', [TareasController::class, 'update'])->name('tareas.update');
    
    //CDP's
    Route::get('/cdps', [ControlPlantacionController::class, 'index'])->name('cdps');
    Route::get('/cdps/create', [ControlPlantacionController::class, 'create'])->name('cdps.create');
    Route::post('/cdps/create', [ControlPlantacionController::class, 'store'])->name('cdps.store');
    
    

    Route::get('/finca/plan-semanal/rendimiento/tarea-{tarealote}/plan-{plansemanalfinca}', [PlanSemanalFincasController::class, 'rendimiento'])->name('planSemanal.rendimiento');
    
    Route::get('/finca/plan-semanal/rendimiento/{usuario}/tarea-{tarealote}/create', [PlanSemanalFincasController::class, 'diario'])->name('planSemanal.diario');
    

    Route::post('/finca/plan-semanal/create', [PlanSemanalFincasController::class, 'store'])->name('planSemanal.store');


    //Lotes
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes');
    Route::get('/lotes/create', [LoteController::class, 'create'])->name('lotes.create');
    Route::get('/lotes/edit/{lote}', [LoteController::class, 'edit'])->name('lotes.edit');
    Route::get('/lotes/historial', [LoteController::class, 'historial'])->name('lotes.historial');
    Route::post('/lotes/create', [LoteController::class, 'store'])->name('lotes.store');
    Route::patch('/lotes/update/{lote}', [LoteController::class, 'update'])->name('lotes.update');
    Route::delete('/{lote}', [LoteController::class, 'destroy'])->name('lotes.destroy');
    
    //Cultivos
    Route::get('/cultivos', [CultivoController::class, 'index'])->name('cultivos');
    Route::get('/cultivos/create', [CultivoController::class, 'create'])->name('cultivos.create');
    Route::get('/cultivos/edit/{cultivo:cultivo}', [CultivoController::class, 'edit'])->name('cultivos.edit');
    Route::post('/cultivos/create', [CultivoController::class, 'store'])->name('cultivos.store');
    Route::patch('/cultivos/update/{cultivo}', [CultivoController::class, 'update'])->name('cultivos.update');
    
    //Tareas
    Route::get('/tareas', [TareasController::class, 'index'])->name('tareas');
    Route::get('/tareas/{tarea:tarea}/rendimiento', [TareasController::class, 'rendimiento'])->name('tareas.rendimiento');


    Route::get('/tarea-lote/create', [TareaLoteController::class, 'create'])->name('planSemanal.tareaLote.create');
    Route::get('/tarea-lote/{tarealote}', [TareaLoteController::class, 'show'])->name('planSemanal.tareaLote.show');

    Route::get('/tarea-lote/{tareaslote}/edit', [TareaLoteController::class, 'edit'])->name('planSemanal.tareaLote.edit');
    
    Route::post('/tarea-lote/store/{lote}/{plansemanalfinca}', [TareaLoteController::class, 'store'])->name('planSemanal.tareaLote.store');

    //Tareas de cosecha
    Route::get('/tarea-lote/cosecha/create', [TareaCosechaLoteController::class, 'create'])->name('planSemanal.tareaCosechaLote.create');

    // Reporteria
    Route::get('/exportar-plansemanal/{planSemanalFinca}', [ReporteController::class, 'PlanSemanal'])->name('reporte.PlanSemanal');
    Route::get('/exportar-planillasemanal/{planSemanalFinca}', [ReporteController::class, 'PlanillaSemanal'])->name('reporte.PlanillaSemanal');
    Route::get('/exportar-control-presupuesto/{semana}', [ReporteController::class, 'ControlPresupuesto'])->name('reporte.ControlPresupuesto');
    Route::get('/exportar-cosecha/{tarealotecosecha}', [ReporteController::class, 'ControlCosecha'])->name('reporte.ControlCosecha');
    
    //Usuarios Fincas
    Route::get('/finca/ingresos', [UsuariosFincaController::class, 'index'])->name('usuariosFincas');
});