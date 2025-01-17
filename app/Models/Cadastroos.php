<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cadastroos extends Model
{
    protected $table = 'cadastro_os';

      // Método para realizar a consulta
      public static function obterDadosComPrefixo()
      {

          return DB::table('cadastro_os as os')
              ->leftJoin('classesos as class', 'class.id', '=', 'os.classes')
              ->leftJoin('clusters as clus', 'clus.id', '=', 'os.cluster')
              ->select(
                  'os.id',
                  'os.Equipe',
                  'os.data',
                  'clus.NomeCluster',
                  'os.endereco',
                  'class.tipoOs',
                  'os.hoInicio',
                  'os.horFim',
                  'os.solClaro',
                  'os.solClaro',
                  'os.idUnicoCluster',
                  DB::raw("CONCAT(Prefixo, '-', NumPrefixo) as Prefixo")
              )
              ->get();
      }
}
