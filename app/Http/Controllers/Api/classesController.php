<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\classeos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class classesController extends Controller
{
    public function index():JsonResponse{
       $cluesters = DB::table('classesos')->select('id', 'tipoOs','idClasseOs')->get();
         return response()->json([
            'Status' => 2,
            'result' => $cluesters,
            'mensage' => 'Sucesso ao consultar'
         ],200);
        }
}
