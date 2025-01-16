<?php

namespace App\Http\Controllers;

use App\Models\descritivo_produto;
use Illuminate\Http\Request;

class FilesController extends Controller
{
   public function ProcessArquivo(Request $files){

      //dd(file($files->file('arquivos')));
      $cabecalho =['descricao','unidadeMedida','tipo'];
      $dadosArquivos = array('str_getcsv',file($files->file('arquivos')));
      $arrayValores = [];  // Declare um array para armazenar todos os resultados

      foreach ($dadosArquivos[1] as $keyCode => $arquivosLinha) {
                      //dd($valuesLinha);
           $valuesLinha  = explode(';',$arquivosLinha);
          // dd($valuesLinha);
           $linha = [];
        foreach ($cabecalho as $keyHeader => $valueHeader) {

            $linha[$valueHeader] = $valuesLinha[$keyHeader];



             }
             $arrayValores[] = $linha;


            }
          //  dd($arrayValores);

            descritivo_produto::insert($arrayValores);

}






   }


