<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function getPhotos($id)
    {

        // Supondo que você tenha uma pasta 'public/uploads/' onde as fotos estão salvas
        $diretorioPrincipal = "storage/app/private/public/image/$id";
        //$photosPath = public_path('public/image/'.$id);
        dd($diretorioPrincipal);

        if (!Storage::exists($diretorioPrincipal)) {
            return response()->json(['status' => 1, 'message' => 'Dados Não localizados'], 404);
        }
        // if (!file_exists($photosPath) || !is_dir($photosPath)) {
        //     return response()->json(['status' => 1, 'message' => 'Dados Não localizados'], 404);
        // }


         if(is_dir($diretorioPrincipal)){

            dd('e um diretorio');
         }
        $files = scandir($diretorioPrincipal);
        $photos = [];

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $photos[] = url('uploads/' . $id . '/' . $file);
            }
        }

        return response()->json(['status' => 0, 'dados' => $photos]);
    }
}
