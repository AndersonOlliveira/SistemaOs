<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuariosTb extends Authenticatable
{
    use HasFactory;
     //tabela náo precisa passar por array, somente o que dentro dela.
     protected $table = 'tb_usuarios';

     protected $fillable = ['id' ,'nome' ,'login','email','senha','nivel','tipoUser','ativo','data_cadastro','alterSenha','recuperar_senha', 'dataAlteracaoPerfil','idUserAlteracaoPerfil'];

     public function getAuthPassword()
    {
        return $this->senha; // Aqui você retorna o nome correto do campo de senha
    }
}
