<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
//rota inicial
Route::get('/', [LoginController::class, 'index'])->name('loginIndex');



