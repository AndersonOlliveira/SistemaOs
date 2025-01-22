<?php

namespace App\Http\Controllers;

use App\Models\Cadastroos;
use App\Models\produtos_usos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\verificarExtensoes;
use App\Models\completo_os;
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
    public function novosDadosOs(Request $retornoNovo)
    {


        $fotoAntes = $retornoNovo->file('fotoAntes');
        $fotoDurante = $retornoNovo->file('fotoDurante');
        $fotosDepois = $retornoNovo->file('fotoDepois');

        // dd($retornoNovo->file());



        $array = ['fotoAnts' => $fotoAntes, 'fotoDurante' => $fotoDurante, 'fotoDepois' => $fotosDepois];

        $validaFotos = $this->verificarExtensoes($array);
        if ($validaFotos) {
            return $validaFotos;
        } else {
            //aqui vou salvar os arquivos
            $salvaFotos = $this->salvaArquivos($array, $retornoNovo->idUnico);
            return $salvaFotos;
           // dd('çai aqui');
        }
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
        //dd($retorno->idCluster);
        if ($dados->count() > 0) {
            //resultado for 0 vou inserir no banco e criar um idestrageiro
            foreach ($dados as $produtoUso) {
                //percorro o dados para achar o id, achando o id vou pegar o ultimo resultado
            }

            for ($h = 1; $h <= $produtoUso->idEstrangeiro; $h++) {
            }
            DB::beginTransaction();
            try {
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
                //  dd($produtosinserts);

                DB::commit();
                return back()->withInput()->with('msg', 'Sucesso ao inserir Dados');
            } catch (\Exception $e) {
                return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                DB::rollBack();
            }



            //o resultado que fica aqui e o que esta disponivel para uso na sequencia.

        } else {

            $idEstrangeiro = 1;
            DB::beginTransaction();
            try {

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
                    // dd($produtosinserts);
                }
                DB::commit();
                return back()->withInput()->with('msg', 'Sucesso ao inserir Dados');
            } catch (\Exception $e) {
                return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                DB::rollBack();
            }
        }
    }

    public function verificarExtensoes($array)
    {

        //dd($array);
        $retornoResultado = [];
        $extensoesValidas = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'pdf'];
        $fotoAntes = $array['fotoAnts'];
        $fotoDurante = $array['fotoDurante'];
        $fotosDepois = $array['fotoDepois'];

        // dd($fotosDepois);
        foreach ($fotoAntes as $value) {
            $extensao = $value->getClientOriginalExtension();  // Retorna a extensão original do arquivo

            // Verificando se a extensão é válida
            if (!in_array(strtolower($extensao), $extensoesValidas)) {
                return redirect()->back()->with('msg', 'Arquivos enviados precisam ser no formato Img, Pdf');
            }
        }

        // Percorrendo as fotos durante
        foreach ($fotoDurante as $value) {
            $extensao = $value->getClientOriginalExtension();  // Retorna a extensão original do arquivo

            // Verificando se a extensão é válida
            if (!in_array(strtolower($extensao), $extensoesValidas)) {
                return redirect()->back()->with('msg', 'Arquivos enviados precisam ser no formato Img, Pdf');
            }
        }
        foreach ($fotosDepois as $value) {
            $extensao = $value->getClientOriginalExtension();  // Retorna a extensão original do arquivo

            // Verificando se a extensão é válida
            if (!in_array(strtolower($extensao), $extensoesValidas)) {
                return redirect()->back()->with('msg', 'Arquivos enviados precisam ser no formato Img, Pdf');
            }
        }
    }
    public function salvaArquivos($dados, $id)
    {
        //passo o id para verificar se existe se existir adiciono caso náo crio
        if (is_dir("public/image/$id")) {
            //dd($dados);
        } else {
            // dd(pathinfo($dados->getOriginalFileName(), PATHINFO_FILENAME));

            //dd($dados);

            $dadosAntes = $dados['fotoAnts'];
            $dadosDurante =  $dados['fotoDurante'];
            $dadosDepois =  $dados['fotoDepois'];

            $pastas = ['Antes', 'Durante', 'Depois'];

            // Criando a pasta principal do ID, se não existir
            $diretorioPrincipal = "public/image/$id";

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



            foreach ($dadosAntes as $dadosA) {
                // Salvando um arquivo dentro da pasta "Antes"
                Storage::put("$diretorioPrincipal/Antes/", $dadosA);
            }
            foreach ($dadosDurante as $dadosD) {
                // Salvando um arquivo dentro da pasta "Durante"
                Storage::put("$diretorioPrincipal/Durante/", $dadosD);
            }

            foreach ($dadosDepois as  $dadosDe) {

                // Salvando um arquivo dentro da pasta "Depois"
                Storage::put("$diretorioPrincipal/Depois/", $dadosDe);
                //dd($dados);
            }

            //procuro para não inserir novamente nesta tela
            $verificaFotos = completo_os::where(['idUnicoClusterComple' => $id])->get();

             if($verificaFotos->count() > 0){
             //como naó vou listar mas este botão vou deixar assim pois inseri normanete, caso tenha alguma bug no envio ele trava o processo
             return back()->withInput()->with('msg', 'Dados já Inseridos');
             }else{
                DB::beginTransaction();

                try{
                        $dadosFotos = [
                         'fotoAntes' => 1,
                         'fotoDurante' => 1,
                         'fotoDepois' => 1,
                         'idUnicoClusterComple' => $id,
                        ];
                        //  completo_os
                      //  dd($dadosFotos);
                        DB::table('completo_os')->insert($dadosFotos);// Dados para a inserção no completo
                        DB::commit();
                        return back()->withInput()->with('msg', 'Sucesso ao inserir Usuário');
                }catch(\Exception $e) {
                    return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                    DB::rollBack();
                }
             }



        }
    }

    public function DadosOsOm(Request $retornoOm){


         // PRECISO VALIDAR OS CAMPOS

        dd($retornoOm);
         $upd = completo_os::where('idUnicoClusterComple', $retornoOm->idUnico)->update(['omClaro' => $retornoOm->omClaro, 'osClaro' => $retornoOm->osClaro,'updated_at' => now()]);

          if($upd > 0){
            return back()->withInput()->with('msg', 'Sucesso ao Inserir Om e Os');
          }else{
            return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
          }
      //   dd($upd);




    }
}
