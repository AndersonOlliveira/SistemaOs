<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcessModel extends Model
{
    protected $table = 'acessos';

    protected $fillable = ['id' ,'usuario_id' ,'pagina_id','consultar','incluir','editar','excluir','data'];
}
