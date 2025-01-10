<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbcidades extends Model
{
    protected $table = 'tb_cidades';

    protected $fillable = ['id','cidade','uf' ,'sigla'];
}
