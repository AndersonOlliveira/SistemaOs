<?php

namespace App\Http\Controllers;

use App\Http\Requests\clusteResquest;
use App\Models\ClusterModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;

class ClusterContoller extends Controller
{
    public function processClustes(clusteResquest $request){
        $request->validated();
     // dd($request);
         if($request->uf == "Selecione Estado"){
            return back()->withInput()->with('msg', 'Por favor Verifique o formulário!');
         }
        //validar input
          $tabela = ClusterModels::where(['NomeCluster' => $request->cidades ,'UfCluster' => $request->uf]);
          //dd($tabela->count());
          //verifico sem registro já criado
          if($tabela->count() > 0){
            return back()->withInput()->with('msg', 'Cluster já Criado por favor Verifique!');
          }else{
            //crio o cluster
            DB::beginTransaction();

            try{

              $clusterData = [
                 'NomeCluster' => $request->cidades,
                 'UfCluster' => $request->uf,
                 'idUserCricaoCluster' => $request->idUser,
                 'created_at' => now(),
              ];


              //dd(Log::info('ClusterData: ', $ClusterData)); // Usando Log para depuração
             DB::table('clusters')->insert($clusterData);// Dados para a inserção no acesso

             DB::commit();
              return back()->withInput()->with('msg', 'Sucesso ao inserir Cluster');
          }catch(\Exception $e) {
               return back()->withInput()->with('msg', 'Falha ao Inserir, por favor contate o Administrador');
              DB::rollBack();
          }


       }
  }
}
