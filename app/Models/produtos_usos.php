<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class produtos_usos extends Model
{
    protected $table = 'produtos_uso';


    public static function obterDadosProdutos($idCidade,$idUnico)
    {

        return DB::table('produtos_uso as pd')
    ->leftJoin('descritivo_produtos as DP', 'DP.ID', '=', 'pd.idProdutoDesc')
    ->select(
        'DP.id',
        'DP.item',
        'DP.descricao',
        'DP.valor',
        'pd.QuantidadeProd',
        'pd.idUnicoCluster'
    )
    ->where('pd.idCidade', '=', $idCidade)  // Condição para 'idCidade'
    ->where('pd.idUnicoCluster', '=', $idUnico)  // Condição para 'idUnicoCluster'
    ->get();
    }
}
