<?php

use App\Http\Controllers\api\CluesterApicontroller;
use App\Http\Controllers\cadastroOsContoller;
use App\Http\Controllers\ClusterContoller;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NovaOsController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
//rota inicial
Route::get('/', [LoginController::class, 'index'])->name('loginIndex');

Route::post('/processarLogin', [LoginController::class, 'processLogin'])->name('processarLogin');

//alterarSenha
Route::post('/processarAlterar', [LoginController::class, 'processAlterarSenha'])->name('processarAlterar');
//clesses
Route::post('/CadClasses', [cadastroOsContoller::class, 'CadastroClases'])->name('CadClases');

Route::get('/AdicionarUser', [HomeController::class, 'adduser'])->name('addUser')->middleware('auth');

Route::get('/ListaUsuarios', [HomeController::class, 'listaUser'])->name('listaUser')->middleware('auth');

Route::post('/AlterPass', [LoginController::class, 'AlterPass'])->name('AlterPass')->middleware('auth');

Route::get('/alterarSenha', [LoginController::class, 'alterarSenha'])->name('alterarSenha')->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('main.home')->middleware('auth');

Route::post('registerUser',[RegisterController::class, 'register'])->name('register');

Route::get('/CadastrarCluster',[HomeController::class, 'cadastrarCluster'])->name('cluster');

Route::get('/listaClasses',[HomeController::class, 'listaClasses'])->name('classes');

Route::get('/',[LoginController::class, 'destroy'])->name('loggout');

Route::post('/ProcessCluster',[ClusterContoller::class, 'processClustes'])->name('ProcessCluster');


Route::post('/ProcessOs',[NovaOsController::class, 'novaOs'])->name('ProcessNovaOs');

Route::post('/files', [FilesController::class, 'ProcessArquivo'])->name('ProcessArquivo');

Route::post('/novosDadosOs', [NovaOsController::class, 'novosDadosOs'])->name('adicionaDos');

Route::post('/DadosOsOm', [NovaOsController::class, 'DadosOsOm'])->name('adicionaOM');

Route::post('/listarFotos', [NovaOsController::class, 'listarFotos'])->name('listarFotos');


Route::post('/adicionaServico', [NovaOsController::class, 'adicionaServico'])->name('adicionaServico');

Route::post('/Allos', [NovaOsController::class, 'AllOms'])->name('AllOms');





