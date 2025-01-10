<?php

use App\Http\Controllers\Api\CidadeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/cidades', [CidadeController::class, 'index']);
