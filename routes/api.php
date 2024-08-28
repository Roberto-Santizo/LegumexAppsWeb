<?php

use App\Http\Controllers\APIAreasController;
use App\Http\Controllers\APIFilesController;
use App\Http\Controllers\APIImagenesController;
use App\Http\Controllers\APISupervisoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/areas', [APIAreasController::class, 'index']);
Route::get('/areas/{planta_id}', [APIAreasController::class, 'show']);
Route::get('/areas/elementos/{area_id}', [APIAreasController::class, 'elementos']);

Route::get('/supervisores/areas', [APISupervisoresController::class, 'supervisoresAreas']);

Route::post('/imagenes/upload', [APIImagenesController::class, 'store'])->middleware('web');

