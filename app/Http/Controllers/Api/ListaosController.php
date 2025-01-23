<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cadastroos;
use App\Models\descritivo_produto;
use App\Models\produtos_usos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
//use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;

class ListaosController extends Controller
{

     public function index() :JsonResponse{

        $os = Cadastroos::obterDadosComPrefixo();

        return response()->json([
           'Status' => 2,
           'data' => $os,
           'mensage' => 'Sucesso ao consultar'
        ],200);
     }


      public function listaProdutos() :JsonResponse{

        $listaProd = descritivo_produto::all();

        return response()->json([
            'Status' => 2,
            'data' => $listaProd,
            'mensage' => 'Sucesso ao consultar'
         ],200);

      }

    //   public function listaDadosCluster(): JsonResponse{

    //     //  //$listaDadosPorCluster = produtos_usos::obterDadosProdutos();

    //     //   return response()->json([
    //     //     'Status' => 2,
    //     //     'result' => $listaDadosPorCluster,
    //     //     'mensage' => 'Sucesso Ao listar Dados'
    //     //  ],200);

    //   }

      public function teste($cluster, $idUnico) {

         // dd($id, $cluster, $idUnico);
          $listaDadosPorCluster = produtos_usos::obterDadosProdutos($cluster,$idUnico);

           //dd($listaDadosPorCluster);
         //
  if($listaDadosPorCluster->count() > 0 ){

        return response()->json([
            'status' => 'success',
            'dados' => $listaDadosPorCluster,
            // Outros dados que você deseja enviar
        ]);
    } return response()->json([
        'status' => '1',
        'dados' => 'Falha ao consultar Verificque',
        // Outros dados que você deseja enviar
    ]);
   }
   public function excel($idUnico) { //:JsonResponse{


        $i_node = 16; //INDICA APARTIR DE QUAL LINHA DEVEMOS COMEÇAR ESCREVER NA PLANILHA
        $templatePath = public_path('/template/lista.xlsx');  // Usando public_path() para obter o caminho correto
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $user = Cadastroos::obterDadosExecell($idUnico);  // Supondo que você tenha dados para preencher

        foreach ($user as $index => $u) {
        $sheet->setCellValue('B7', $u->data);

        $multiplicar = $u->valor * $u->QuantidadeProd;
        $valorUnitario = 'R$ ' . number_format($u->valor, 2, ',', '.');
        $valorFormatado = 'R$ ' . number_format($multiplicar, 2, ',', '.');

        // Preencher os dados na planilha a partir da linha $i_node

            $sheet->setCellValue('A' . ($i_node + $index), $u->item);        // Exemplo: CÓDIGO
            $sheet->setCellValue('B' . ($i_node + $index), $u->descricao);      // Exemplo: descricao
            $sheet->setCellValue('H' . ($i_node + $index), $u->unidadeMedida);     // Exemplo: unidadeMedida
            $sheet->setCellValue('I' . ($i_node + $index), $u->QuantidadeProd); // Exemplo: Data de Criação
            $sheet->setCellValue('J' . ($i_node + $index), $valorUnitario); // Exemplo: Data de Atualização
            $sheet->setCellValue('K' . ($i_node + $index), $valorFormatado); // Exemplo: Data de Atualização
            $sheet->setCellValue('K' . ($i_node + $index), $valorFormatado); // Exemplo: Data de Atualização
           // $sheet->setCellValue('C'. ($i_node + $index),$somar); // Exemplo: Data de Atualização

        }

         // Criar o Writer para salvar o arquivo Excel
        $writer = new Xlsx($spreadsheet);

        // Definir o nome do arquivo para download
        $filename = 'user_template_filled.xlsx';

        // Fazer o download do arquivo gerado sem a necessidade de ZIP
        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');  // Salvar diretamente para a saída (stream)
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

}

