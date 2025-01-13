<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ClusterModels;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CluesterApicontroller extends Controller
{

    public function index() :JsonResponse{

        $cluesters = ClusterModels::all();
         return response()->json([
            'Status' => 2,
            'result' => $cluesters,
            'mensage' => 'Sucesso ao consultar'
         ],200);
        }
}
