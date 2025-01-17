<?php

namespace App\Http\Controllers;

use App\Models\Cadastroos;
use App\Models\produtos_usos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NovaOsController extends Controller
{
    public function novaOs(Request $dadosOs)
    {
        //preciso colocar a Osrequest

        // $dadosBanco = Cadastroos::where(['cluster' => $dadosOs]);
        //dd($dadosBanco->count());

        //náo localizado passo para inserir
        //if($dadosBanco->count() > 0){
        // dd('prossigo para inserir dados dentro do banco');
        //dd($dadosOs);

        //}else{
        //dd('prossigo para inserir dados dentro do banco');
        // dd($dadosOs);

        //preparar para inserir
        $numeroRan = date('d') + date('m') + date('y') + date('h') + date('i') + date('s');

        DB::beginTransaction();
        try {

            $dadosInsert = [
                'Equipe' => $dadosOs->nameEquipe,
                'data' => $dadosOs->data,
                'cluster' => $dadosOs->cluster,
                'endereco' => $dadosOs->endereco,
                'classes' => $dadosOs->classe,
                'hoInicio' => $dadosOs->hoInicio,
                'horFim' => $dadosOs->horFim,
                'solClaro' => $dadosOs->solClaro,
                'Prefixo' => $dadosOs->Prefixo,
                'NumPrefixo'  => $dadosOs->NumPrefixo,
                'idUnicoCluster' => $numeroRan,
                'created_at' => now()
            ];

            DB::table('cadastro_os')->insert($dadosInsert);

            DB::commit();
            return back()->withInput()->with('msg', 'Sucesso ao inserir Usuário');
            //dd('no commit');
        } catch (\Exception $e) {
            return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
            DB::rollBack();
            //dd('no rollBack');
        }
    }

    //receber dados adicionais da os
    public function novosDadosOs(Request $retorno) {}

    public function adicionaServico(Request $retorno)
    {

       /// dd($retorno);
     //adicionar uma coluna na tabela de cluster, onde vai ter um id randomico sera usado para inserir da tabela de cluster, e na tabela de produtos assim realiza a busca na tabela com o id randomico

        // aqui vou procurar o banco
        $produtos = [];
        $produtoCount = 0;
        while ($retorno->has("nomeProduto" . ($produtoCount + 2))) {
            $produtoCount++;
        }
        // dd($produtoCount);

        for ($i = 2; $i <= $produtoCount + 1; $i++) {
            $produtos[] = [
                'nomeProduto' => $retorno->input("nomeProduto{$i}"),
                'idProduto' => $retorno->input("Idproduto{$i}"),
                'quantidade' => $retorno->input("quantidade{$i}")
            ];
        }


        $dados = produtos_usos::where(['idCidade' => $retorno->idCluster])->select('idEstrangeiro')->groupBy('idEstrangeiro')->get();

        if ($dados->count() > 0) {
            //resultado for 0 vou inserir no banco e criar um idestrageiro
            foreach ($dados as $produtoUso) {
                //percorro o dados para achar o id, achando o id vou pegar o ultimo resultado
            }

            for ($h = 1; $h <= $produtoUso->idEstrangeiro; $h++) {

            }
            DB::beginTransaction();
             try{
                foreach ($produtos as $key => $value) {
                 $produtosinserts = [
                    'idProdutoDesc' => $value['idProduto'],
                    'QuantidadeProd' => $value['quantidade'],
                    'idCidade' =>  $retorno->idCluster,
                    'idEstrangeiro' => $h,
                    'idUser' => $retorno->idUser,
                    'idUnicoCluster' => $retorno->idUnico,
                    'created_at' => now(),
                 ];
                 DB::table('produtos_uso')->insert($produtosinserts);
                }
                //dd($produtosinserts);

                   DB::commit();
                    return back()->withInput()->with('msg', 'Sucesso ao inserir Dados');
                 }catch(\Exception $e) {
                      return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                     DB::rollBack();
                  }



            //o resultado que fica aqui e o que esta disponivel para uso na sequencia.

          }else{

             $idEstrangeiro = 1;
              DB::beginTransaction();
              try{
                foreach ($produtos as $key => $value) {
                $produtosinserts = [
                   'idProdutoDesc' => $value['idProduto'],
                   'QuantidadeProd' => $value['quantidade'],
                   'idCidade' =>  $retorno->idCluster,
                   'idEstrangeiro' => $idEstrangeiro,
                   'idUser' => $retorno->idUser,
                   'idUnicoCluster' => $retorno->idUnico,
                   'created_at' => now(),
                ];

                DB::table('produtos_uso')->insert($produtosinserts);
              }
                  DB::commit();
                   return back()->withInput()->with('msg', 'Sucesso ao inserir Dados');
                }catch(\Exception $e) {
                   return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                    DB::rollBack();
                 }

            }





    }
}
