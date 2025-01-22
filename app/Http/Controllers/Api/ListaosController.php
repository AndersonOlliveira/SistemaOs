<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cadastroos;
use App\Models\descritivo_produto;
use App\Models\produtos_usos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ListaosController extends Controller
{

     public function index() :JsonResponse{

        $os = Cadastroos::obterDadosComPrefixo();

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

    //   public function listaDadosCluster(): JsonResponse{

    //     //  //$listaDadosPorCluster = produtos_usos::obterDadosProdutos();

    //     //   return response()->json([
    //     //     'Status' => 2,
    //     //     'result' => $listaDadosPorCluster,
    //     //     'mensage' => 'Sucesso Ao listar Dados'
    //     //  ],200);

    //   }

      public function teste($cluster, $idUnico) {

         // dd($id, $cluster, $idUnico);
          $listaDadosPorCluster = produtos_usos::obterDadosProdutos($cluster,$idUnico);

           //dd($listaDadosPorCluster);
         //
  if($listaDadosPorCluster->count() > 0 ){

        return response()->json([
            'status' => 'success',
            'dados' => $listaDadosPorCluster,
            // Outros dados que você deseja enviar
        ]);
    } return response()->json([
        'status' => '1',
        'dados' => 'Falha ao consultar Verificque',
        // Outros dados que você deseja enviar
    ]);

     }



    //  public function adicionarOs(Request $request, Response $response):JsonResponse{

    //     return response()->json([
    //         'Status' => 2,
    //         'data' => $request,
    //         'mensage' => 'Sucesso ao consultar'
    //      ],400);


    //  }


}
