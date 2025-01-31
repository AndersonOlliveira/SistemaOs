<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function index(){

        return view('main.home');
    }


     public function adduser(){
         // com isso consigo validar quem acessa a rota
         if(Gate::denies('addUser')){
            return view('main.home')->with('msg', 'Sem acesso a esta página');
         }else{
            return view('main.addUser');

         }

     }

     public function cadastrarCluster(){

        return view('main.cidades');
     }


public function listaClasses(){

  return view('main.classes');
}

public function listaUser(){

    return view('main.listaUser');
}

}
