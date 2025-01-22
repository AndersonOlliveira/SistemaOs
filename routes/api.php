<?php

use App\Http\Controllers\Api\CidadeController;
use App\Http\Controllers\Api\classesController;
use App\Http\Controllers\api\CluesterApicontroller;
use App\Http\Controllers\Api\ListaosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/cidades', [CidadeController::class, 'index']);
Route::get('/ApiCluster', [CluesterApicontroller::class, 'index'])->name('ClusterApi');
Route::get('/ApiClasse', [classesController::class, 'index'])->name('ClassesApi');
Route::get('/ListaOs', [ListaosController::class, 'index'])->name('listarOs');
// Route::post('/adicionarOs', [ListaosController::class, 'adicionarOs'])->name('adicionarOs');
Route::get('/ListaProdutos', [ListaosController::class, 'listaProdutos'])->name('listaProdutos');

Route::get('/ListaDadosClusters', [ListaosController::class, 'listaDadosCluster'])->name('listaDados');

Route::get('/Listateste/{cluster}/{idUnico}', [ListaosController::class, 'teste'])->name('listateste');

Route::get('/excel/{idUnico}', [ListaosController::class, 'excel'])->name('gerarExcel');


