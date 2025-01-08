<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosTb extends Model
{
     //tabela náo precisa passar por array, somente o que dentro dela.
     protected $table = 'tb_usuarios';

     protected $fillable = ['id' ,'nome' ,'login','email','senha','nivel','tipoUser','ativo','data_cadastro','alterSenha','recuperar_senha', 'dataAlteracaoPerfil','idUserAlteracaoPerfil'];
}
