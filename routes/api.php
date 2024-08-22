<?php

use App\Http\Controllers\APIAreasController;
use App\Http\Controllers\APILotesController;
use App\Http\Controllers\APISupervisoresController;
use App\Http\Controllers\APITareasLotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/areas', [APIAreasController::class, 'index']);
Route::get('/areas/{planta_id}', [APIAreasController::class, 'show']);
Route::get('/areas/elementos/{area_id}', [APIAreasController::class, 'elementos']);

Route::get('/supervisores/areas', [APISupervisoresController::class, 'supervisoresAreas']);

Route::get('/lotes/{finca_id}', [APILotesController::class, 'lotes']);

Route::post('/tarea/usuario/asignar', [APITareasLotesController::class, 'store']);
