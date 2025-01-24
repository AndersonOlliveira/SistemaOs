<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Static_;

class Cadastroos extends Model
{
    protected $table = 'cadastro_os';

      // Método para realizar a consulta
      public static function obterDadosComPrefixo()
      {

          return DB::table('cadastro_os as os')
              ->leftJoin('classesos as class', 'class.id', '=', 'os.classes')
              ->leftJoin('clusters as clus', 'clus.id', '=', 'os.cluster')
              ->leftJoin('completo_os as cpl', 'cpl.idUnicoClusterComple', '=', 'os.idUnicoCluster')
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
                  'cpl.fotoAntes',
                  'cpl.omClaro',
                  DB::raw("CONCAT(Prefixo, '-', NumPrefixo) as Prefixo")
              )->where('os.idProcess', '<>', 10)
              ->get();
      }

      public static function obterDadosExecell($idUnico){

        return DB::table('cadastro_os as cad')
        ->leftJoin('produtos_uso as pd', 'pd.idUnicoCluster', '=' ,'cad.idUnicoCluster')
        ->leftJoin('descritivo_produtos as dp','dp.id', '=' ,'pd.idProdutoDesc')
        ->leftJoin('completo_os as cp' ,'cp.idUnicoClusterComple',  '=', 'cad.idUnicoCluster')
        ->leftjoin('clusters as cl', 'cl.id', '=', 'pd.idCidade')
        ->select('*'
        )->where('pd.idUnicoCluster', '=', $idUnico)  // Condição para 'idUnicoCluster'
        ->get();

      }


       public static function obterOsfechadas(){
        return DB::table('cadastro_os as os')
        ->leftJoin('classesos as class', 'class.id', '=', 'os.classes')
        ->leftJoin('clusters as clus', 'clus.id', '=', 'os.cluster')
        ->leftJoin('completo_os as cpl', 'cpl.idUnicoClusterComple', '=', 'os.idUnicoCluster')
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
            'cpl.fotoAntes',
            'cpl.omClaro',
            DB::raw("CONCAT(Prefixo, '-', NumPrefixo) as Prefixo")
        )->where('os.idProcess', '=', 10)
        ->get();
      }
}
