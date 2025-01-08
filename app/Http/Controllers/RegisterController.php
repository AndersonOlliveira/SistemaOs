<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormularioResquest;
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

         //vou procurar no banco se tem user cadastrado

         $procurar = UsuariosTb::where(['login' => $dados->login, 'email' => $dados->email])->first();

          if($procurar == null) {

            //dd($dados);


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

               try {
                   // Dados para a inserção do usuário
                   $userData = [
                       'nome' => $dados->nome,
                       'login' => $dados->login,
                       'email' => $dados->email,
                       'senha' => $senha,
                       'nivel' => $dados->selecionar,
                       'tipoUser' => $cadastroUsers,
                       'data_cadastro' => now(),
                   ];

                  // dd($userData);
                   $userId = DB::table('tb_usuarios')->insertGetId($userData);

         // Dados para a inserção no acesso
            $accessData = [
                'usuario_id' => $userId,
                'consultar' => $consultar,
                'incluir' => $incluir,
                'editar' => $editar,
                'excluir' => $excluir,
                'data' => now(),
            ];

            // Inserção no acesso
            DB::table('acessos')->insert($accessData);

            // Commit da transação
            DB::commit();


   }catch (\Exception $e) {

                    // Rollback da transação em caso de erro
         DB::rollBack();
 }




             //vou inserir no banco na tabela de usuarios e acessos

            //  DB::table('tb_usuarios')->insertUsing(
            //     ['user_id', 'title', 'content'], // colunas da tabela `posts`
            //     function ($query) {
            //         $query->from('users')
            //               ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            //               ->select('users.id as user_id', 'profiles.title', 'profiles.content')
            //               ->whereNotNull('profiles.title');
            //     }
            // );

          }
        // dd($procurar);

        return back()->withInput()->with('msg', 'Informações já utilizadas');


         } else{

         return back()->withInput()->with('msg', 'Campos não podem ser vazios');


      }



    }
}
