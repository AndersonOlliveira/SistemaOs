<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
//rota inicial
Route::get('/', [LoginController::class, 'index'])->name('loginIndex');

Route::post('/processarLogin', [LoginController::class, 'processLogin'])->name('processarLogin');

//alterarSenha
Route::post('/processarAlterar', [LoginController::class, 'processAlterarSenha'])->name('processarAlterar');

Route::get('/AdicionarUser', [HomeController::class, 'adduser'])->name('addUser')->middleware('auth');

Route::get('/alterarSenha', [LoginController::class, 'alterarSenha'])->name('alterarSenha')->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('main.home')->middleware('auth');

Route::post('registerUser',[RegisterController::class, 'register'])->name('register');

Route::get('/',[LoginController::class, 'destroy'])->name('loggout');



