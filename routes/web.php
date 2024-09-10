<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FirmaController;

use App\Http\Controllers\DashboardController;

//rutas de agricola
require __DIR__ . '/administracion.php';
require __DIR__ . '/agricola.php';
require __DIR__ . '/mantenimiento.php';
require __DIR__ . '/auth.php';

//Página Principal
Route::get('/', HomeController::class)->name('home');

//Firmas
Route::post('/firmas',[FirmaController::class,'store'])->middleware('auth');

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware(['auth']);

