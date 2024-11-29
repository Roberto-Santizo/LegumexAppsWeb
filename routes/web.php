<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificacionController;

require __DIR__ . '/mantenimiento.php';
require __DIR__ . '/administracion.php';
require __DIR__ . '/agricola.php';
require __DIR__.'/auth.php';


Route::get('/', HomeController::class)->name('home');

Route::post('/firmas',[FirmaController::class,'store'])->middleware('auth');

Route::get('/dashboard')->middleware(['auth','RoleRedirect'])->name('dashboard');

Route::get('/novedades',[NotificacionController::class,'index'])->middleware(['auth'])->name('novedades');

Route::get('/dashboard/administracion',[DashboardController::class,'index'])->middleware(['auth','role:admin','checkupdate'])->name('dashboard.administracion');
Route::get('/dashboard/mantenimiento',[DashboardController::class,'mantenimiento'])->middleware(['auth','role:admin|adminmanto|auxmanto','checkupdate'])->name('dashboard.mantenimiento');
Route::get('/dashboard/agricola',[DashboardController::class,'agricola'])->middleware(['auth','role:admin|adminagricola|auxfinca','checkupdate'])->name('dashboard.agricola');

