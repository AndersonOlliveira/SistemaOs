<?php

namespace App\Http\Controllers;

use App\Models\classeos;
use Illuminate\Http\Request;

class ValidaCamposController extends Controller
{

    public function validaOs($dadosOs)
    {

        //  dd($dadosOs);
        if (!isset($dadosOs->nameEquipe)) {

            return back()->withInput()->with('msg', 'Campo Equipe Não pode ser Vazio');
        }
        if (!isset($dadosOs->data)) {

            return back()->withInput()->with('msg', 'Campo Data Não pode ser Vazio');
        }
        if (!isset($dadosOs->endereco)) {

            return back()->withInput()->with('msg', 'Campo Endereço Não pode ser Vazio');
        }
        if (!isset($dadosOs->solClaro)) {

            return back()->withInput()->with('msg', 'Campo Solicitante Claro Não pode ser Vazio');
        }
        if (!isset($dadosOs->hoInicio)) {

            return back()->withInput()->with('msg', 'Campo Hora Inicio Não pode ser Vazio');
        }
        if (!isset($dadosOs->horFim)) {

            return back()->withInput()->with('msg', 'Campo Hora Fim Não pode ser Vazio');
        }
        if (!isset($dadosOs->Prefixo)) {

            return back()->withInput()->with('msg', 'Campo Prefixo Não pode ser Vazio');
        }
        if (!isset($dadosOs->NumPrefixo)) {

            return back()->withInput()->with('msg', 'Campo Número Prefixo Não pode ser Vazio');
        }
        if (!isset($dadosOs->NumPrefixo)  && ($dadosOs->NumPrefixo != 'Selecione Classe')) {

            return back()->withInput()->with('msg', 'Campo Classe Prefixo Não pode ser Vazio');
        }
        if (!isset($dadosOs->NumPrefixo)  && ($dadosOs->NumPrefixo != 'Selecione Cluster')) {

            return back()->withInput()->with('msg', 'Campo Cluster Prefixo Não pode ser Vazio');
        }
    }

    public function validaIdUnico($id){

        if (!isset($id)) {

            return back()->withInput()->with('msg', 'Não exite Id Unico');
        }
    }

    public function validaCamposFotos($dados){

        $fotoAntes = $dados['fotoAnts'];
        $fotoDurante = $dados['fotoDurante'];
        $fotosDepois = $dados['fotoDepois'];

        if (!isset($fotoAntes)) {

            return back()->withInput()->with('msg', 'Campo Foto Não pode ser Vazio');
        }
        if (!isset($fotoDurante)){

            return back()->withInput()->with('msg', 'Campo Foto Não pode ser Vazio');
        }
        if (!isset($fotosDepois)) {

            return back()->withInput()->with('msg', 'Campo Foto Não pode ser Vazio');
        }
    }

    public function validaOm($dados){

        if (!isset($dados->omClaro)){

            return back()->withInput()->with('msg', 'Campo omClaro Não pode ser Vazio');
        }
        if (!isset($dados->osClaro)) {

            return back()->withInput()->with('msg', 'Campo osClaro Não pode ser Vazio');
        }

        if (!isset($dados->idUnico)) {

            return back()->withInput()->with('msg', 'Campo id Unico Não pode ser Vazio');
        }

    }
    public function validaCamposServico($dados){

        $produtoCount = 0;
        while ($dados->has("nomeProduto" . ($produtoCount + 2))) {
            $produtoCount++;
        }
         if($produtoCount == 0 ){
            return back()->withInput()->with('msg', 'Campos Serviços Não pode ser Vazio');
         }

    }
   public function validaId($dados){
        //d($dados);
      if (!isset($dados)) {

        return response()->json([
            'status' => '2',
            'message' => 'Campo id Unico Não pode ser Vazio',
            // Outros dados que você deseja enviar
        ]);

    }

   }
   public function validaCclasses($dados){

       if (!isset($dados->Nclasse)) {

            return back()->withInput()->with('msg', 'Campo Classes Não pode ser Vazio');
        }

        //procuro no banco
        $todos = classeos::all();
        $enviFormulario = mb_strtoupper($dados->Nclasse);

         foreach($todos as $valores){
         $valoresUpper = mb_strtoupper($valores->tipoOs);

          if($valoresUpper == $enviFormulario){
             return back()->withInput()->with('msg', 'Já tem Classe com este Nome Verifique');
          }
        }

   }
   public function validaArquivo($arquivo){

    // dd($arquivo);
      if(empty($arquivo->file('arqquivoCsv'))){
        return back()->withInput()->with('msg', 'Campo Arquivo Não pode ser Vazio verifique!');

    }
        //   dd(file($arquivo->file('arqquivoCsv')));
   }
}
