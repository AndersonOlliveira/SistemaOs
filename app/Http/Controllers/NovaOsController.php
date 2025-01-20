<?php

namespace App\Http\Controllers;

use App\Models\Cadastroos;
use App\Models\produtos_usos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\verificarExtensoes;
use Illuminate\Support\Facades\Storage;

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
    public function novosDadosOs(Request $retornoNovo) {

         $array = ['fotoAnts' => $retornoNovo->fotoAntes, 'fotoDurante' => $retornoNovo->fotoDurante, 'fotosfotoDepois' => $retornoNovo->fotoDepois];

         $validaFotos = $this->verificarExtensoes($array);
            //se for valido
          if($validaFotos == 'Continuar'){
            //verifico se tem a pasta pasta par inserir.

            $salvaFotos = $this->salvaArquivos($array, $retornoNovo->idUnico);

             dd($salvaFotos);
          }



         //passo para verificar o tipo do arquivo se uma foto


         //dd($retornoNovo->fotoAntes);




    }

    public function adicionaServico(Request $retorno)
    {

       //dd($retorno);
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

        public function verificarExtensoes($array){

            //  ; dd($array);
              $arquivosEnviados = false;
              $extensaoNecessaria =  ['png','jpeg','jpg'];
              //$verificaExtensoes = $_FILES['files']['name'];
              if($array){
                $retornoExtensao = [];
                foreach($array as $nomesArquivos){

                   $retornoExtensao[] = strtolower($nomesArquivos->getMimeType());

                }

                $formatosValidos = ['image/png', 'image/jpg', 'image/jpeg'];

                // Verificando se todos os arquivos são válidos
                foreach ($retornoExtensao as $extensao) {
                    if (!in_array($extensao, $formatosValidos)) {
                        // Se algum arquivo não for válido
                        $refArquiovos = 'Por favor Enviar fotos no formato PNG ou Jpg';
                        return $refArquiovos;
                    }
                }

                // Se todos os arquivos forem válidos
                $refArquiovos = 'Continuar';
                return $refArquiovos;
            }



    }

    public function salvaArquivos($dados,$id){
        //passo o id para verificar se existe se existir adiciono caso náo crio
        if(is_dir("image/$id")){
           // dd($dados);

          }else{
             //dd('ñ tem diretorio');
             $pastas = ['Antes', 'Durante', 'Depois'];

             // Criando a pasta principal do ID, se não existir
             $diretorioPrincipal = "image/$id";
             //dd($diretorioPrincipal);

             if (!Storage::exists($diretorioPrincipal)) {
                 Storage::makeDirectory($diretorioPrincipal); // Cria a pasta principal
             }

             // Criando as subpastas dentro da pasta do ID
             foreach ($pastas as $pasta) {
                 $caminho = "$diretorioPrincipal/$pasta";
                 if (!Storage::exists($caminho)) {
                     Storage::makeDirectory($caminho); // Cria a subpasta
                 }
             }

             // Agora você pode salvar os dados nas respectivas pastas
             $dados = "Conteúdo do arquivo";

             // Salvando um arquivo dentro da pasta "Antes"
             Storage::put("$diretorioPrincipal/Antes/arquivo.txt", $dados);

             // Salvando um arquivo dentro da pasta "Durante"
             Storage::put("$diretorioPrincipal/Durante/arquivo.txt", $dados);

             // Salvando um arquivo dentro da pasta "Depois"
             Storage::put("$diretorioPrincipal/Depois/arquivo.txt", $dados);
            //dd($dados);







          }
    }
 }

