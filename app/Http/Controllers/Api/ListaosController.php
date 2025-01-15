<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cadastroos;
use Illuminate\Http\Request;

class ListaosController extends Controller
{

     public function index(){

        $os = Cadastroos::obterDadosComPrefixo();

        //dd($os);

        return response()->json([
           'Status' => 2,
           'data' => $os,
           'mensage' => 'Sucesso ao consultar'
        ],200);
     }
}
