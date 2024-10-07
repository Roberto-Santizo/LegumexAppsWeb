<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MicrosoftAuthController;


//Autenticación
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'store']);
Route::post('/logout/user',[LogoutController::class,'store'])->name('logout');

//Autenticación microsoft
Route::get('/login/microsoft',[MicrosoftAuthController::class,'redirectToMicrosoft'])->name('redirectToMicrosoft');
Route::get('/login/microsoft/callback',[MicrosoftAuthController::class,'handleMicrosoftCallback'])->name('handleMicrosoftCallback');
Route::post('/logout',[MicrosoftAuthController::class,'logout'])->name('logout.microsoft');
Route::get('/post-logout', [MicrosoftAuthController::class, 'postLogout'])->name('post-logout');
