<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tbcidades;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function index() :JsonResponse{

        $cidades = Tbcidades::all();
         return response()->json([
            'Status' => 2,
            'message' => $cidades,
         ],200);
        }

}
