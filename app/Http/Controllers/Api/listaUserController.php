<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class listaUserController extends Controller
{

    public function ListaUser() : JsonResponse{

          $user = User::all();

          return response()->json([
            'Status' => 2,
            'data' => $user,
            'mensage' => 'Sucesso ao consultar'
        ], 200);


    }
}
