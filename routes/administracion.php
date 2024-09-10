<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SupervisoresController;

//Administrador
Route::group(['middleware' => ['role:admin'], 'prefix' => 'administracion/usuarios'], function() {
    //Usuarios
    Route::get('/', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('/create', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/create', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::get('/edit/{usuario:name}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::patch('/update/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('usuarios.roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('usuarios.roles-create');
    Route::post('/roles/create', [RoleController::class, 'store'])->name('usuarios.roles-store');
    Route::get('/roles/edit/{role}', [RoleController::class, 'edit'])->name('usuarios.roles-edit');
    Route::patch('/roles/update/{role}', [RoleController::class, 'update'])->name('usuarios.roles-update');

    //Permisos
    Route::get('/permisos', [PermissionController::class, 'index'])->name('usuarios.permissions');
    Route::get('/permisos/create', [PermissionController::class, 'create'])->name('usuarios.permissions-create');
    Route::post('/permisos/create', [PermissionController::class, 'store'])->name('usuarios.permissions-store');
    Route::get('/permisos/edit/{permission}', [PermissionController::class, 'edit'])->name('usuarios.permissions-edit');
    Route::patch('/permisos/update/{permission}', [PermissionController::class, 'update'])->name('usuarios.permissions-update');

    //Supervisores
    Route::get('/supervisores', [SupervisoresController::class, 'index'])->name('usuarios.supervisores');
    Route::get('/supervisores/create', [SupervisoresController::class, 'create'])->name('usuarios.supervisores-create');
    Route::post('/supervisores/create', [SupervisoresController::class, 'store'])->name('usuarios.supervisores-store');
    Route::get('/supervisores/edit/{supervisor:name}', [SupervisoresController::class, 'edit'])->name('usuarios.supervisores-edit');
    Route::patch('/supervisores/edit/{supervisor:name}', [SupervisoresController::class, 'update'])->name('usuarios.supervisores-update');
    Route::delete('/supervisores/{supervisor}', [SupervisoresController::class, 'destroy'])->name('usuarios.supervisores-destroy');
});