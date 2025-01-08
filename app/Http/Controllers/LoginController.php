<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginResquest;
use App\Models\UsuariosTb;
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

   /// dd($resquest);

     $retorno = $this->validar($resquest);

     return $retorno;

  }

  public function validar($resquest){
      //verifico se usuario e senhas sáo validos
    //dd(Auth::guard('custom_guard')->attempt(['login' => $resquest->login , 'senha' => $resquest->password]));
 dd(bcrypt($resquest->password));

 if(!Auth::guard('custom_guard')->attempt(['login' => $resquest->login , 'senha' => $resquest->password])){

           return back()->withInput()->with('msg', 'Usuario ou senha inválidos');

      }

     return redirect()->route('main.home');
  }
  public function alterarSenha(){

     return view('login.alterarSenha');
  }

  public function processAlterarSenha(Request $dados){

      //dd($dados);

      $retornoDadosbd = UsuariosTb::where(['login' => $dados->login ,'email'=> $dados->email])->first();


    //   $valor = $retornoDadosbd->count();
    //   dd($valor);
      if($retornoDadosbd == null){

        return view('login.alterarSenha');

      }


}


}
