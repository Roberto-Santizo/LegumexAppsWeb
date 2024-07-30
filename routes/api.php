<?php

use App\Http\Controllers\APIAreasController;
use App\Http\Controllers\APIFilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/api/areas', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');s


Route::get('/areas', [APIAreasController::class, 'index']);
Route::get('/areas/{planta_id}', [APIAreasController::class, 'show']);
Route::get('/areas/elementos/{area_id}', [APIAreasController::class, 'elementos']);
// Route::prefix('api')->middleware('auth')->group(function () {
// });

