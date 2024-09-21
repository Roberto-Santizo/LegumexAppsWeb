<?php

use App\Http\Controllers\APIAreasController;
use App\Http\Controllers\APILotesController;
use App\Http\Controllers\APIImagenesController;
use App\Http\Controllers\APIRendimientoTareasController;
use App\Http\Controllers\APISupervisoresController;
use App\Http\Controllers\APITareasLotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/areas', [APIAreasController::class, 'index'])->middleware('web');
Route::get('/areas/{planta_id}', [APIAreasController::class, 'show']);
Route::get('/areas/elementos/{area_id}', [APIAreasController::class, 'elementos'])->middleware('web');

Route::get('/rendimiento/{tarea}/{finca}/{year}', [APIRendimientoTareasController::class, 'rendimiento']);

Route::get('/supervisores/areas', [APISupervisoresController::class, 'supervisoresAreas'])->middleware('web');

Route::post('/imagenes/upload', [APIImagenesController::class, 'store'])->middleware('web');

Route::get('/lotes/{finca_id}', [APILotesController::class, 'lotes'])->middleware('web');

Route::post('/tarea/usuario/asignar', [APITareasLotesController::class, 'store'])->middleware('web');
Route::post('/tarea/usuario/desasignar', [APITareasLotesController::class, 'destroy'])->middleware('web');
