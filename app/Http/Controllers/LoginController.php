<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginResquest;
use App\Models\UsuariosTb;
use App\Models\User;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function index(){

          return view('login.index');
    }

  //processar login

  public function processLogin(LoginResquest $resquest){



     $retorno = $this->validar($resquest);

     return $retorno;

  }

  public function validar($resquest){
      $resquest->validated();
     //procuro o user no banco,
      $retornoBan = User::where(['login' => $resquest->login])->first();

      if($retornoBan == null){

         return back()->withInput()->with('msg', 'Usuario ou senha Não Localizado');
      }
       $credentials = ['email' => $retornoBan->email, 'password' => $resquest->password];

      if(!Auth::attempt($credentials)){

        return back()->withInput()->with('msg', 'Usuario ou senha inválidos');

    }
        return redirect()->route('main.home');
  }


  public function alterarSenha(){

     return view('login.alterarSenha');
  }

  public function processAlterarSenha(Request $dados){

      $retornoDadosbd = UsuariosTb::where(['login' => $dados->login ,'email'=> $dados->email])->first();

      if($retornoDadosbd == null){

        return view('login.alterarSenha');

      }
    }

      public function destroy(){

           Auth::logout();

         return view('login.index');
      }


}



