<?php

namespace App\Http\Controllers;

use App\Models\Cadastroos;
use App\Models\produtos_usos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\verificarExtensoes;
use App\Http\Requests\Osresquest;
use App\Models\completo_os;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ValidaCamposController;



class NovaOsController extends Controller
{
    public function novaOs(Request $dadosOs)
    {

       // dd($dadosOs);
        $controllerValidade = new  ValidaCamposController();
        //chamando outra contoller pra validar
        $r = $controllerValidade->validaOs($dadosOs);
        if ($r) {

            return $r;
        }

        //preparar para inserir
        $numeroRan = date('d') + date('m') + date('y') + date('h') + date('i') + date('s');
        $process = 0;

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
                'idProcess' => $process,
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

        $array = ['fotoAnts' => $fotoAntes, 'fotoDurante' => $fotoDurante, 'fotoDepois' => $fotosDepois];
        $controllerValidadeFotos = new  ValidaCamposController();
        //chamando outra contoller pra validar
        $r = $controllerValidadeFotos->validaCamposFotos($array);

         if($r){

            return $r;
        }


        $validaFotos = $this->verificarExtensoes($array);
        if ($validaFotos) {
            return $validaFotos;
        } else {
            //aqui vou salvar os arquivos
            $salvaFotos = $this->salvaArquivos($array, $retornoNovo->idUnioEditar);
            return $salvaFotos;
            // dd('çai aqui');
        }
    }

    public function adicionaServico(Request $retorno)
    {

         $controllerValidadeServicos = new  ValidaCamposController();
        //chamando outra contoller pra validar
         $r = $controllerValidadeServicos->validaCamposServico($retorno);
         if($r){
            return $r;
        }
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

        $controllerIdunico = new  ValidaCamposController();
        //chamando outra contoller pra validar
        $r = $controllerIdunico->validaIdUnico($id);
        if ($r) {

            return $r;
        }

        //passo o id para verificar se existe se existir adiciono caso náo crio
        if (is_dir("public/image/$id")) {
            //dd($dados);
        } else {
            // dd(pathinfo($dados->getOriginalFileName(), PATHINFO_FILENAME));

           // dd($dados);
               $dadosAntes = $dados['fotoAnts'];
               $dadosDurante =  $dados['fotoDurante'];
               $dadosDepois =  $dados['fotoDepois'];

            $inputValuesdadosAntes = [];
            $inputValuesdadosDurante = [];
            $inputValuesdadosDepois = [];
            foreach($dadosAntes as $f ){
               $name =  $f->getClientOriginalName();
               $inputValuesdadosAntes[] = $name;
               $juntarAntes = implode(';', $inputValuesdadosAntes);
             }
              foreach($dadosDurante as $f ){
                $name =  $f->getClientOriginalName();
                $inputValuesdadosDurante[] = $name;
                $juntarDurante = implode(';', $inputValuesdadosDurante);
              }
              foreach($dadosDepois as $f ){
                $name =  $f->getClientOriginalName();
                $inputValuesdadosDepois[] = $name;
                $juntarDepois = implode(';', $inputValuesdadosDepois);
              }

            // $dadosAntes = $dados['fotoAnts'];
            // $dadosDurante =  $dados['fotoDurante'];
            // $dadosDepois =  $dados['fotoDepois'];

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
                $nomeArquivo = $dadosA->getClientOriginalName();
                // dd($nomeArquivo);
                $caminhoArquivo = "$diretorioPrincipal/Antes/" . $nomeArquivo;
               Storage::put($caminhoArquivo, file_get_contents($dadosA->getRealPath()));
            }
            foreach ($dadosDurante as $dadosD) {
                $nomeArquivoD = $dadosD->getClientOriginalName();
                $caminhoArquivod = "$diretorioPrincipal/Durante/" . $nomeArquivoD;
                 //náo passando o nome do arquivo ele salva um nome aleatorio dentro do banco.
                 Storage::put($caminhoArquivod, file_get_contents($dadosA->getRealPath()));
           }

            foreach ($dadosDepois as  $dadosDe) {
                $nomeArquivoDe = $dadosDe->getClientOriginalName();
                $caminhoArquivode = "$diretorioPrincipal/Depois/" . $nomeArquivoDe;
                 //náo passando o nome do arquivo ele salva um nome aleatorio dentro do banco.
                 Storage::put($caminhoArquivode, file_get_contents($dadosA->getRealPath()));
            }

            //procuro para não inserir novamente nesta tela
            $verificaFotos = completo_os::where(['idUnicoClusterComple' => $id])->get();

            if ($verificaFotos->count() > 0) {
                //como naó vou listar mas este botão vou deixar assim pois inseri normanete, caso tenha alguma bug no envio ele trava o processo
                return back()->withInput()->with('msg', 'Dados já Inseridos');
            } else {
                DB::beginTransaction();

                try {
                    $dadosFotos = [
                        'fotoAntes' => 1,
                        'fotoDurante' => 1,
                        'fotoDepois' => 1,
                        'fotoDuranteT' => $juntarDurante,
                        'fotoDepoisT' => $juntarDepois,
                        'fotoAntesT' => $juntarAntes,
                        'updated_at' => now(),
                        'idUnicoClusterComple' => $id,
                    ];
                    //  completo_os
                     // dd($dadosFotos);
                    DB::table('completo_os')->insert($dadosFotos); // Dados para a inserção no completo
                    DB::commit();
                    return back()->withInput()->with('msg', 'Sucesso ao inserir Usuário');
                } catch (\Exception $e) {
                    return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                    DB::rollBack();
                }
            }
         }
    }



    public function DadosOsOm(Request $retornoOm)
    {
        $controllerIdunicoOM = new  ValidaCamposController();
        //chamando outra contoller pra validar
        $r = $controllerIdunicoOM->validaOm($retornoOm);
        if ($r) {

            return $r;
        }


        // PRECISO VALIDAR OS CAMPOS
        $upd = completo_os::where('idUnicoClusterComple', $retornoOm->idUnico)->update(['omClaro' => $retornoOm->omClaro, 'osClaro' => $retornoOm->osClaro, 'updated_os' => now()]);

        if ($upd > 0) {
            return back()->withInput()->with('msg', 'Sucesso ao Inserir Om e Os');
        } else {
            return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
        }
        //   dd($upd);
  }
    public function listarFotos(Request $idFotos){

          $file = $idFotos->file('fotoAntes');
          //dd($file);
          $inputValues = [];
           foreach($file as $f ){
            $name =  $f->getClientOriginalName();
            //  echo "<pre>";
            // print_r($name);
            // echo "</pre>";


              $inputValues[] = $name;
              $juntar = implode(';', $inputValues);
            //  echo "<pre>";
            //  print_r($juntar);
            //  echo "</pre>";

            //  $numero = [];
            //  for ($J = 1; isset($_POST["input{$J}"]) && isset($_POST["numero{$J}"]); $J++) {
            //             // Obtendo o valor de cada input e adicionando ao array
            //             $inputValues[] = $_POST["input{$J}"];
            //             $numero[] = $_POST["numero{$J}"];

            //          }
                       //junto todos os cabos e depois vou recuperar e separar por ponto e virgula
                         //$juntar = implode(';', $inputValues);
                          // echo "<pre>";
                          // print_r($juntar);

             //  $f->store();

         //  $updd = completo_os::where('idUnicoClusterComple', $idFotos->idUnico)->update(['fotoAntesT' => $juntar]);




          }

          //tentar Exibir a image/
          $upd = completo_os::where('idUnicoClusterComple', $idFotos->idUnico)->select('fotoAntesT')->first();
        //   echo "<pre>";
        //   print_r($upd->fotoAntesT);
        //   echo "</pre>";

            //separar nome

            $nomeSeparado = explode(';', $upd->fotoAntesT);
            echo "<pre>";
            print_r($nomeSeparado);
            echo "</pre>";
             foreach($nomeSeparado as $arquivos){
                echo "<pre>";
                print_r($arquivos);
                echo "</pre>";


             $path = storage_path("public\image\\".$idFotos->idUnico.'\Antes\\' . $arquivos);

             $resultado = Storage::files('/public/image/'.$idFotos->idUnico.'/Antes/'. $arquivos);
                //  echo '<img src="{{ asset('. $resultado.') }}" alt="Imagem">';
                echo "<img src='{{ asset('/image/'.$idFotos->idUnico.'/Antes/'. $arquivos') }}' alt='Imagem' style='width: 500px; height: auto; margin: 10px;'>";
                // <img src="{{asset('storage/'.$image_name}}">
            }
                 echo "<pre>";
                 print_r($path);
                 echo "</pre>";
                 if (!empty($resultado)) {
                    echo "<div>"; // Pode adicionar uma div para agrupar as imagens
                    foreach ($resultado as $arquivo) {
                        // Gera a URL pública para cada imagem
                        echo "<pre>";
                        print_r($arquivo);
                        echo "</pre>";
                        $urlImagem = Storage::url($arquivo);
                        echo "<pre>";
                        print_r($urlImagem);
                        echo "</pre>";
                        //  <img src='$completo'style='width:200px; margin 10px;'>
                                          // Exibe a imagem usando a tag <img>


                        print_r( "<img src=' $urlImagem' alt='Imagem' style='width: 300px; height: auto; margin: 10px;'>");
                    }
                    echo "</div>";
                } else {
                    echo "Nenhuma imagem encontrada.";
                }

             }


        public function AllOms(Request $dados){

            return back()->withInput()->with('msg', 'Botão em Construção!');
        }


       //   $file->move(public_path('teste'), $name);






        // $templatePath = public_path('/storage/public');
        // $files = Storage::files('/storage/public/image/'.$idFotos.'/Antes');
        // dd($files);

        // $da = public_path('storage/image/'. $idFotos->idUnico);

        //   if (Storage::get($templatePath)) {

        //      dd("t");
        // }
        // //dd($da);

        // if(is_dir($da)){
        //     dd("e um diretorio");
        // }

}
// }
