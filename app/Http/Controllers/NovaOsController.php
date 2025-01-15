<?php

namespace App\Http\Controllers;

use App\Models\Cadastroos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NovaOsController extends Controller
{
   public function novaOs(Request $dadosOs){
     //preciso colocar a Osrequest

    // $dadosBanco = Cadastroos::where(['cluster' => $dadosOs]);
     //dd($dadosBanco->count());

      //náo localizado passo para inserir
     //if($dadosBanco->count() > 0){
       // dd('prossigo para inserir dados dentro do banco');
        //dd($dadosOs);

    //}else{
        //dd('prossigo para inserir dados dentro do banco');
       // dd($dadosOs);

     //preparar para inserir

     DB::beginTransaction();
     try{
       $dadosInsert = [
        'Equipe' => $dadosOs->nameEquipe,
        'data' => $dadosOs->data,
        'cluster' => $dadosOs->cluster,
        'endereco' => $dadosOs->endereco,
        'classes' => $dadosOs->classe,
        'hoInicio' => $dadosOs->hoInicio,
        'horFim' => $dadosOs->horFim,
        'solClaro' => $dadosOs->solClaro,
        'Prefixo' => $dadosOs->Prefixo,
        'NumPrefixo'  => $dadosOs->NumPrefixo,
        'created_at' => now()
      ];

      DB::table('cadastro_os')->insert($dadosInsert);

      DB::commit();
       return back()->withInput()->with('msg', 'Sucesso ao inserir Usuário');
    //dd('no commit');
    }catch(\Exception $e ){
        return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
        DB::rollBack();
        //dd('no rollBack');
    }
    }
 }

