<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormularioResquest;
use App\Models\User;
use App\Models\UsuariosTb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(FormularioResquest $dados){
        ///vou validar
        $veficarCampos = $this->verificar($dados);

        return $veficarCampos;
    }

    public function verificar($dados){

      if(!empty($dados)){

        if(!isset($dados->selecionar)){

            return back()->withInput()->with('msg', 'Campos não podem ser vazios c');
        }
         //vou procurar no banco se tem user cadastrado
         $procurar = User::where(['login' => $dados->login, 'email' => $dados->email])->first();



          if($procurar != null) {
        // dd('e dirente de null');
          return back()->withInput()->with('msg', 'Dados Enviados já utilizado por outro Usuário');

        }else{

            switch ($dados->selecionar) {
                case 0:
                    $cadastroUsers =  "User";
                    break;
                case 1:
                    $cadastroUsers =  "Adminstrador";
                    break;
                case 2:
                    $cadastroUsers =  "Desenvolvedor";
                    break;
                case 3:
                    $cadastroUsers =  "Projetos";
                case 4:
                    $cadastroUsers =  "Operador";
                 }

                 switch ($cadastroUsers) {
                    case 'User':
                        $consultar = 1;
                        $incluir = 1;
                        $editar = 0;
                        $excluir = 0;
                        $projetoVisium = 0;
                        break;

                    case 'Administrador':
                    case 'Desenvolvedor':
                        $consultar = 1;
                        $incluir = 1;
                        $editar = 1;
                        $excluir = 1;
                        $projetoVisium = 2;
                        break;

                    case 'Projetos':
                        $consultar = 1;
                        $incluir = 1;
                        $editar = 0;
                        $excluir = 0;
                        $projetoVisium = 1;
                        break;

                    case 'Operador':
                        $consultar = 1;
                        $incluir = 1;
                        $editar = 0;
                        $excluir = 0;
                        $projetoVisium = 0;
                        break;

                    default:
                        // Defina os valores padrão ou trate o erro aqui, se necessário
                        $consultar = 0;
                        $incluir = 0;
                        $editar = 0;
                        $excluir = 0;
                        $projetoVisium = 0;
                        break;
                }

                 $senha = Hash::make($dados->senha);


                 DB::beginTransaction();

                  try{
                    $userData = [
                       'name' => $dados->nome,
                       'login' => $dados->login,
                       'email' => $dados->email,
                       'password' => $senha,
                       'nivel' => $dados->selecionar,
                       'tipoUser' => $cadastroUsers,
                    ];
                    $userId = DB::table('users')->insertGetId($userData);// Dados para a inserção no acesso
              $accessData = [
                'usuario_id' => $userId,
                'consultar' => $consultar,
                'incluir' => $incluir,
                'editar' => $editar,
                'excluir' => $excluir,
                'data' => now(),
               ];
                   DB::table('acessos')->insert($accessData);
                   DB::commit();
                   return back()->withInput()->with('msg', 'Sucesso ao inserir Usuário');
                }catch(\Exception $e) {
                    return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
                    DB::rollBack();
                }

           }
      }
       else{

            return back()->withInput()->with('msg', 'Campos não podem ser vazios');
      }



    }
}
