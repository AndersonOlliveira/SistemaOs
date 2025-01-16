<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cadastroos;
use App\Models\descritivo_produto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ListaosController extends Controller
{

     public function index() :JsonResponse{

        $os = Cadastroos::obterDadosComPrefixo();

        //dd($os);

        return response()->json([
           'Status' => 2,
           'data' => $os,
           'mensage' => 'Sucesso ao consultar'
        ],200);
     }


      public function listaProdutos() :JsonResponse{

        $listaProd = descritivo_produto::all();

        return response()->json([
            'Status' => 2,
            'data' => $listaProd,
            'mensage' => 'Sucesso ao consultar'
         ],200);

      }


    //  public function adicionarOs(Request $request, Response $response):JsonResponse{

    //     return response()->json([
    //         'Status' => 2,
    //         'data' => $request,
    //         'mensage' => 'Sucesso ao consultar'
    //      ],400);


    //  }


}
