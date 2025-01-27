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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
//use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Drawing;
use ZipArchive;

class ListaosController extends Controller
{

    public function index(): JsonResponse
    {

        $os = Cadastroos::obterDadosComPrefixo();

        return response()->json([
            'Status' => 2,
            'data' => $os,
            'mensage' => 'Sucesso ao consultar'
        ], 200);
    }


    public function osFechadas(): JsonResponse
    {

        $fechar = Cadastroos::obterOsfechadas();

        return response()->json([
            'Status' => 2,
            'data' => $fechar,
            'mensage' => 'Sucesso ao consultar'
        ], 200);
    }


    public function listaProdutos(): JsonResponse
    {

        $listaProd = descritivo_produto::all();

        return response()->json([
            'Status' => 2,
            'data' => $listaProd,
            'mensage' => 'Sucesso ao consultar'
        ], 200);
    }

    //   public function listaDadosCluster(): JsonResponse{

    //     //  //$listaDadosPorCluster = produtos_usos::obterDadosProdutos();

    //     //   return response()->json([
    //     //     'Status' => 2,
    //     //     'result' => $listaDadosPorCluster,
    //     //     'mensage' => 'Sucesso Ao listar Dados'
    //     //  ],200);

    //   }

    public function teste($cluster, $idUnico)
    {

        //   dd($cluster, $idUnico);
        $listaDadosPorCluster = produtos_usos::obterDadosProdutos($cluster, $idUnico);

        //dd($listaDadosPorCluster);
        //
        if ($listaDadosPorCluster->count() > 0) {

            return response()->json([
                'status' => 'success',
                'dados' => $listaDadosPorCluster,
                // Outros dados que você deseja enviar
            ]);
        }
        return response()->json([
            'status' => '1',
            'dados' => 'Falha ao consultar Verificque',
            // Outros dados que você deseja enviar
        ]);
    }


    public function formatarValor($valor)
    {
        // Remove o "R$" e a vírgula e converte para número (float)
        return (float) str_replace(['R$', '.'], ['', ''], $valor);
    }

    public function excel($idUnico)
    { //:JsonResponse{
        ini_set('max_execution_time', 3600); // 3600 seconds = 60 minutes
        set_time_limit(3600);


        $i_linha = 16; //INDICA APARTIR DE QUAL LINHA DEVEMOS COMEÇAR ESCREVER NA PLANILHA
        $templatePath = public_path('/template/lista.xlsx');  // Usando public_path() para obter o caminho correto
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $user = Cadastroos::obterDadosExecell($idUnico);  // Supondo que você tenha dados para preencher
        $numero = [];
        $valores = [];

        foreach ($user as $index => $u) {

            $explode = explode(';', $u->fotoAntesT);
            foreach ($explode as $key => $value) {

              //  $diretorio = storage_path('public/image/' . $idUnico . '/Antes/' . $value);

                $url = Storage::url('public/image/' . $idUnico . '/Antes/' . $value);
                $base = base_path('public/image/' . $idUnico . '/Antes/' . $value);
                ///dd($url);

                $drawing = new Drawing();
                $drawing->setWorksheet($sheet);
                $drawing ->setName('Paid');
                $drawing ->setDescription('Paid');
                $drawing ->setPath('storage/public/image/' . $idUnico . '/Antes/' . $value);
                $drawing ->setCoordinates('M16');
                // $drawing ->setOffsetX(110);
                // $drawing ->setRotation(25);
                 $drawing->setHeight(200);

                // $spreadsheet->getActiveSheet()->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);
                //$drawing->setWorksheet($spreadsheet->getActiveSheet());
            //     $sheet->getShadow()->setVisible(true);
            //     $sheet->getShadow()->setDirection(45);
             }





            $sheet->setCellValue('B8', $u->data);
            $sheet->setCellValue('C2', $u->NomeCluster);
            $sheet->setCellValue('B9', $u->updated_os);
            $sheet->setCellValue('B10', $u->NomeCluster);
            $multiplicar = ((int)$u->valor * (int)$u->QuantidadeProd);
            $valores[] = $multiplicar;
            $valorUnitario = 'R$ ' . number_format((int)$u->valor, 2, ',', '.');
            $valorFormatado = 'R$ ' . number_format((int)$multiplicar, 2, ',', '.');
            // Preencher os dados na planilha a partir da linha $i_node

            $sheet->setCellValue('A' . ($i_linha + $index), $u->item);
            $sheet->setCellValue('B' . ($i_linha + $index), $u->descricao);
            $sheet->setCellValue('H' . ($i_linha + $index), $u->unidadeMedida);
            $sheet->setCellValue('I' . ($i_linha + $index), (int)$u->QuantidadeProd);
            $sheet->setCellValue('J' . ($i_linha + $index), $valorUnitario);
            $sheet->setCellValue('K' . ($i_linha + $index), $valorFormatado);
            $numero[] = $i_linha + $index + 10;
        }
        // Variável para armazenar a soma total
        $total = 0;
        foreach ($valores as $valor) {
            $total += $this->formatarValor($valor);
        }
        $totalFor = "R$ " . number_format($total, 2, ',', '.');
        $sheet->setCellValue('C' . (end($numero)), $totalFor);

        // Criar o Writer para salvar o arquivo Excel
        $writer = new Xlsx($spreadsheet);

        // Definir o nome do arquivo para download
        $filename = 'lista_materiais_filled.xlsx';

        // Fazer o download do arquivo gerado sem a necessidade de ZIP
        return response()->stream(
            function () use ($writer) {
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
