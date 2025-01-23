<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidaCamposController;
use App\Models\Cadastroos;
use App\Models\completo_os;
use Illuminate\Http\Request;

class fecharOsContoller extends Controller
{
    public function getFechar($id){

       // dd($id);
        $validaId = new  ValidaCamposController();
        //chamando outra contoller pra validar
         $r = $validaId->validaId($id);
         if($r){
            return $r;
        }

        $idProcess = 10;
        $upd = Cadastroos::where('idUnicoCluster', $id)->update(['idProcess' => $idProcess,'updated_at' => now()]);

         if($upd)
        return response()->json([
            'status' => '1',
            'message' => 'Sucesso em Fechar Os',
            // Outros dados que você deseja enviar
        ]);

    //aqui vou realizar um update nas tabelas.
    }
}
