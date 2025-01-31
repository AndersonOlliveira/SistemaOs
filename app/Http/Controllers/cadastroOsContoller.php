<?php

namespace App\Http\Controllers;

use App\Models\classeos;
use Illuminate\Http\Request;

class cadastroOsContoller extends Controller
{

    public function CadastroClases(Request $dados){

        $numeroRan = date('d') + date('m') + date('y') + date('h') + date('i') + date('s');
        $controllerValidade = new  ValidaCamposController();
        //chamando outra contoller pra validar
        $retorno  = $controllerValidade->validaCclasses($dados);
        if ($retorno) {

            return $retorno;
        }

        if(!$retorno){
            $dadosInserir = new classeos();
            $dadosInserir->tipoOs = $dados->Nclasse;
            $dadosInserir->idClasseOs = $numeroRan;
            $dadosInserir->save();
            return back()->withInput()->with('msg', 'Cadastrado Com Sucesso');

        }





    }
}
