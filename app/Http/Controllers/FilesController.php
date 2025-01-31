<?php

namespace App\Http\Controllers;

use App\Models\descritivo_produto;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
   public function ProcessArquivo(Request $files){
      $arquivo = $files;
      $validarArquivo = new ValidaCamposController();
      $retorno = $validarArquivo->validaArquivo($arquivo);
      if($retorno){
        return $retorno;
      }

     // dd($files);

      $cabecalhoValidar = [];
      $cabecalho = ['item','descricao','unidadeMedida','tipo','valor'];
      $cabecalhoValidar = ['item;descricao;unidadeMedida;tipo;valor'];
      $dadosArquivos = array('str_getcsv', file($files->file('arqquivoCsv')));
      $arrayValores = [];  // Declare um array para armazenar todos os resultados
      $cabecalhoArquivo = str_getcsv($dadosArquivos[1][0]);
      //dd($cabecalhoArquivo);

      if ($cabecalhoArquivo != $cabecalhoValidar) {

        return back()->withInput()->with('msg', 'Cabecalho diferente do enviando por favor verifique');
           } else {
            print_r('posso proseguir');


    }
      foreach ($dadosArquivos[1] as $keyCode => $arquivosLinha) {
           if($keyCode == 0)
              continue;
           $valuesLinha  = explode(';',$arquivosLinha);
           $linha = [];
      foreach ($cabecalho as $keyHeader => $valueHeader) {
               $linha[$valueHeader] = $valuesLinha[$keyHeader];
            }

             $valores = str_replace("R$", '', $linha['valor']);

             $item = $linha['item'];
             $description = mb_convert_encoding($linha['descricao'], mb_detect_encoding($linha['descricao']), 'UTF-8');
             $unidade = $linha['unidadeMedida'];
             $servico = $linha['tipo'];
             $valor = $valores;
             $idunico = $files->idUnioClasse;

             $arrayValores[] = $linha;

             DB::beginTransaction();

             try{
               $dadoPlanilhas = [
                  'item' => $item,
                  'descricao' => $description,
                  'unidadeMedida' => $unidade,
                  'tipo' => $servico,
                  'valor' => $valor,
                  'created_at' => now(),
                  'fkidClasses' => $idunico,
           ];
               DB::table('descritivo_produtos')->insert($dadoPlanilhas);
               DB::commit();
               return back()->withInput()->with('msg', 'Sucesso ao inserir Usuário');
           }catch(\Exception $e) {
               return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
               DB::rollBack();
           }

      }
         }



           // descritivo_produto::insert($arrayValores);

}





