<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\DashboardController;

//Rutas por área
require __DIR__ . '/mantenimiento.php';
require __DIR__ . '/administracion.php';
require __DIR__ . '/agricola.php';
require __DIR__ . '/auth.php';

//Página Principal
Route::get('/', HomeController::class)->name('home');

//Firmas
Route::post('/firmas',[FirmaController::class,'store'])->middleware('auth');

//Dashboard
Route::get('/dashboard')->middleware(['auth','RoleRedirect'])->name('dashboard');


Route::get('/dashboard/administracion',[DashboardController::class,'index'])->middleware(['auth','role:admin'])->name('dashboard.administracion');
Route::get('/dashboard/mantenimiento',[DashboardController::class,'mantenimiento'])->middleware(['auth','role:admin|adminmanto|auxmanto'])->name('dashboard.mantenimiento');
Route::get('/dashboard/agricola',[DashboardController::class,'agricola'])->middleware(['auth','role:admin|adminagricola|auxalameda'])->name('dashboard.agricola');

