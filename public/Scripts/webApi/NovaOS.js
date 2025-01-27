//const { data } = require("autoprefixer");

// const { data } = require("jquery");

//const { list } = require("postcss");

var MvcController = new function () {
    this.Call = function Call(_type, _url, _dataType, _param, _method) {
        CarregaClusters();
        $.ajax({
            type: _type,
            url: _url,
            cache: false,
            dataType: _dataType,
            data: _param,
            success: function (d) { _method(d); },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown.message);

            }
        }).always(function () { StopLoad(); });
    }
};
$(document).ready(function () {
    CarregaClusters();
});
$(document).ready(function () {
    CarregaClasses();
});
$(document).ready(function () {
    CarregaOs();
});
$(document).ready(function () {
    carregarOsfechada();
});

$(document).ready(function () {
    CarregaProdutos();
});
function CarregaClusters() {
    $.ajax({
        url: 'api/ApiCluster',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.result;

                /*.log(response);*/
                // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
                $.each(dados, function (i, val) {
                    // Append tem a função de inserir

                    $('#clusters').append($("<option>", { name: 'cluster', value: val.id, text: val.NomeCluster }));
                });
            } else {
                alert(response.Result);
            }
        },
        error: function (xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });

}
function ListarDadosRota(rowId,rowIdUnico){
    montarFotos(rowIdUnico);
   $.ajax({
    url: "api/Listateste/" + rowId + '/' + rowIdUnico, // A URL com o parâmetro
    method: "GET",                           // Método HTTP
    dataType: "json",                        // Espera uma resposta no formato JSON
    success: function(response) {
      if(response.status == 1) {

       alert('Dados Não localizados Por favor preencha envie os dados' );

        }else{
          var dados = response.dados
         // console.log(dados);
          //chamo outra funcao para listar as fotos

            montarTabela(dados);
           // Exibe a resposta no console

      }
    },

    error: function(xhr, status, error) {
        alert.error("Erro na requisição:", error);
    }

});

function montarFotos(id){
    // $.ajax({
    //     url: "api/SolitaFoto/" + id, // A URL com o parâmetro
    //     method: "GET",                           // Método HTTP
    //     dataType: "json",                        // Espera uma resposta no formato JSON
    //     success: function(response) {
    //       if(response.status == 1) {

    //        alert('Dados Não localizados Por favor preencha envie os dados' );

    //         }else{
    //           var dados = response.dados
    //           console.log(dados);

    //       }
    //     },

    //     error: function(xhr, status, error) {
    //         alert.error("Erro na requisição:", error);
    //     }

    // });

}


function montarTabela(dados){
     tabelaData = [];

     //console.log(dados);

     $.each(dados, function (i, val) {
        // Append tem a função de inserir
         // Adicionando os dados no array para preencher a tabela
         var items = val.item;

         var descricoes = val.descricao;
       //  var itemComDescription = items.concat('-' + descricoes);
         var itemComDescription = (items ? items: 'Valor não disponível') + '-' + (descricoes ? descricoes: 'Descrição não disponível');

         var total = val.valor * val.QuantidadeProd;
         let valorFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

         $('#staticBackdrop').modal('show');
         tabelaData.push({
            id: val.id,
            descripion: itemComDescription,
            valor: val.valor,
            quantidade: val.QuantidadeProd,
            total: valorFormatado
        });
      // Aqui você pode preencher o formulário do modal com os dados da linha

        $('#idUnico').val(val.idUnicoCluster);

    });
  // Inicializando o DataTable
    $('#ListaDados').DataTable({
        data: tabelaData,
        //column: title('New title'),
        order: [
            [0, 'desc']
        ],
             "columnDefs": [{
                "visible": true,
                "targets": -1
            }],
        scrollX: true,
        paging: false,
        searching: false,
        destroy: true,
        language: {
            emptyTable: "Sem dados a ser apresentado"
        },
        columns: [
            { data: 'id' },
            { data: 'descripion' },
            { data: 'valor' },
            { data: 'quantidade' },
            { data: 'total' }
        ]
    });
}

    // $.ajax({
    //     url: 'api/ListaDadosClusters',  // Rota criada em Laravel
    //     type: 'GET',
    //     dataType: 'json',
    //     success: function (response) {
    //         if (response.Status == 2) {
    //             var dados = response.result;
    //             console.log(dados);
    //             // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
    //             $.each(dados, function (i, val) {
    //                 // Append tem a função de inserir
    //                 $('#classes').append($("<option>", { value: val.id, text: val.tipoOs }));
    //             });
    //         } else {
    //             alert(response.Result);
    //         }
    //     },
    //     error: function (xhr, status, error) {
    //         console.log("Erro ao carregar cluster: " + error);
    //     }
    // });

}


function CarregaClasses() {
    $.ajax({
        url: 'api/ApiClasse',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.result;
                // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
                $.each(dados, function (i, val) {
                    // Append tem a função de inserir
                    $('#classes').append($("<option>", { value: val.id, text: val.tipoOs }));
                });
            } else {
                alert(response.Result);
            }
        },
        error: function (xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });
}

function carregarOsfechada(){
    $(document).ready(function () {
        $('#listaOFechada').DataTable({
            scrollX: true,
            ajax: {
                url: '/api/ListaOsFechadas',
                // method:'get', // URL da API
                dataSrc: 'data',  // Define que a resposta será um array (sem chave para acessar)
              },

            columns: [
                { data: 'id' },
                { data: 'Equipe' },
                { data: 'NomeCluster' },
                { data: 'Prefixo' },
                { data: 'data' },
                { data: 'endereco' },
                { data: 'hoInicio' },
                { data: 'horFim' },
                { data: 'solClaro' },
                { data: 'tipoOs' }
            ]
    });
 });
}

function CarregaOs() {

    $(document).ready(function () {
      var  table = $('#listaOs').DataTable({
            scrollX: true,
            ajax: {
                url: '/api/ListaOs',
                // method:'get', // URL da API
                dataSrc: 'data',  // Define que a resposta será um array (sem chave para acessar)
              },
              columnDefs: [
                {
                    orderable: false,
                    render: DataTable.render.select(),
                    targets: 0
                }
            ],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            columns: [
                { data: 'id' },
                { data: 'Equipe' },
                { data: 'NomeCluster' },
                { data: 'Prefixo' },
                { data: 'data' },
                { data: 'endereco' },
                { data: 'hoInicio' },
                { data: 'horFim' },
                { data: 'solClaro' },
                { data: 'tipoOs' }, //trocado para exibir o correto
            //     { // Coluna para os botões
            //         data: null,
            //         render: function (data, type, row) {

            //              if(row.fotoAntes == null){
            //             return '<button class="btn btn-warning btnEditar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '"  data-target=".bd-example-modal-lg">Complentar Os</button>';

            //             }else if(row.omClaro == null){
            //                  return '<button class="btn btn-info btnCompletar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '"  data-target=".bd-example-modal-lg">Inserir Om ,Os Claro </button>';

            //             }else{
            //                 return '<button class="btn btn-success" onclick="enviarFormulario(' + row.idUnicoCluster + ')">Solicitar Execell</button>';

            //             }
            //         }
            //      },
            //     { // Coluna para os botões
            //         data: null,
            //         render: function (data, type, row) {
            //             return '<button class="btn btn-secondary btnServicos" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Adiconar Serviços </button>';
            //         }
            //     },
            //      { // Coluna para os botões
            //         data: null,
            //         render: function (data, type, row) {
            //             return '<button class="btn btn-info btnDados" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Listar Dados</button>';
            //         }
            //     },
            //     { // Coluna para os botões
            //         data: null,
            //         render: function (data, type, row) {
            //             return '<button class="btn btn-danger btnFechar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Fechar Os</button>';
            //         }
            //     },
            //     // { // Coluna para os botões
            //     //      data: null,
            //     //     render: function (data, type, row) {
            //     //         return '<input type="hidden" data-idunicocluster="' + row.idUnicoCluster + '"  data-target=".bd-example-modal-lg"/>';
            //     //      }
            //     //  },
            // ]
           { data: null,
            render: function (data, type, row) {
            var buttons = '';

            // Verifica a condição para adicionar o botão "Complentar Os"
            if (row.fotoAntes == null) {
                buttons += '<button class="btn btn-warning btnEditar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Complentar Os</button> ';
            }
            // Verifica a condição para adicionar o botão "Inserir Om, Os Claro"
            else if (row.omClaro == null) {
                buttons += '<button class="btn btn-info btnCompletar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Inserir Om ,Os Claro </button> ';
            }
            // Se nenhuma das condições anteriores, adiciona o botão "Solicitar Execell"
            else {
                buttons += '<button class="btn btn-success" onclick="enviarFormulario(' + row.idUnicoCluster + ')">Solicitar Execell</button> ';
            }

            // Botão para adicionar serviços
            buttons += '<button class="btn btn-secondary btnServicos" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Adiconar Serviços </button> ';

            // Botão para listar dados
            buttons += '<button class="btn btn-info btnDados" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Listar Dados</button> ';

            // Botão para fechar os
            buttons += '<button class="btn btn-danger btnFechar" onclick="FecharOs(' + row.idUnicoCluster + ', ' + row.id + ')"> Fechar Os</button>';

            buttons += '<button class="btn btn-danger btnFechar" id="meuBotao"data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '"  > teste</button>';

            return buttons;
        },
    }
    ]
});

$('#listaOs').on('click', '#meuBotao', function() {
    // Obtém as linhas selecionadas
    var selectedRows = table.row({ selected: true }).data();

    //console.log(selectedRows);
    var idsSelecionados = [];

    // Pega os IDs das linhas selecionadas
    selectedRows.foreach(function(rowData) {
        idsSelecionados.push(rowData.id); // Aqui você pega o ID da linha (ajuste conforme a sua estrutura de dados)
    });

    if (idsSelecionados.length > 0) {
        // Faça algo com os IDs selecionados, como exibir ou processar as informações
        console.log("IDs selecionados: ", idsSelecionados);

        // Por exemplo, aqui você pode adicionar uma nova informação às linhas selecionadas
        selectedRows.each(function(rowData, index) {
            // Suponhamos que você queira modificar um campo específico das linhas selecionadas:
            table.cell(rowData, 2).data('Nova informação').draw(); // Aqui, altere a célula da coluna 2
        });

    } else {
        alert("Nenhuma linha selecionada!");
    }
});

        // Evento para abrir o modal ao clicar no botão "Editar"
        $('#listaOs tbody').on('click', '.btnEditar', function () {
            var rowId = $(this).data('id');
            var rowIdUnico = $(this).data('unico');
            //console.log(rowIdUnico);
            var nomeCluster = $(this).data('nome');
            // Aqui você pode preencher o formulário do modal com os dados da linha
            $('#campoNome').val(nomeCluster);
            $('#idCluster').val(rowId);
            $('#idUnioEditar').val(rowIdUnico);
            //preenchêr campos

            // chama o modal
            $('#modalAdicionar').modal('show');
            // $('#modalServicos').modal('show');
        });

        $('#listaOs tbody').on('click', '.btnServicos', function () {
            var rowId = $(this).data('id');
            var rowIdUnico = $(this).data('unico');
            var nomeCluster = $(this).data('nome');
            // Aqui você pode preencher o formulário do modal com os dados da linha
            $('#campoNome').val(nomeCluster);
            $('#idClusterServicos').val(rowId);
            $('#idUnicos').val(rowIdUnico);
            //preenchêr campos

            // chama o modal
            // $('#modalAdicionar').modal('show');
            $('#modalServicos').modal('show');
        });

        $('#listaOs tbody').on('click', '.btnDados', function () {
            var rowId = $(this).data('id');
            var rowIdUnico = $(this).data('unico');
            var nomeCluster = $(this).data('nome');
            // Aqui você pode preencher o formulário do modal com os dados da linha
            $('#campoNome').val(nomeCluster);
            $('#idCluster').val(rowId);
            $('#idUnicos').val(rowIdUnico);
            //preenchêr campos

            // chama o modal

            listaFotos(rowIdUnico);
             ListarDadosRota(rowId,rowIdUnico);
        });

        $('#listaOs tbody').on('click', '.btnCompletar', function () {
            var rowId = $(this).data('id');
            var rowIdUnico = $(this).data('unico');
            //console.log(rowIdUnico);
            var nomeCluster = $(this).data('nome');
            // Aqui você pode preencher o formulário do modal com os dados da linha
            $('#campoNome').val(nomeCluster);
            $('#idCluster').val(rowId);
            $('#idUnicoOm').val(rowIdUnico);
            //preenchêr campos

            // chama o modal
            $('#modalOMOS').modal('show');
            // $('#modalServicos').modal('show');
        });


        // Evento para salvar os dados no formulário
        /* $('#btnSalvar').click(function() {
             var nome = $('#campoNome').val();
             var equipe = $('#campoEquipe').val();
             var foto = $('#campoFoto')[0].files[0];  // Coletar a foto do campo de input
             console.log(nome);
             console.log(equipe);
             console.log(foto);

             const formData = new FormData();
             formData.append('campoNome', nome);
             formData.append('campoEquipe', equipe);
             formData.append('campoFoto', foto);



             // Enviar os dados para a API via AJAX
             $.ajax({
                 url: '/api/adicionarOs',  // URL do script PHP
                 method: 'POST',
                 data: formData,
                 "_token": "{{ csrf_token() }}", // Se necessário


                 processData: false,  // Não processar os dados
                 contentType: false,  // Deixar o conteúdo em formato multipart
                 success: function(response) {
                     console.log(formData);
                     alert('OS adicionada com sucesso!');
                     $('#modalAdicionar').modal('hide');
                     //table.ajax.reload(); // Recarrega a tabela após a adição
                 },
                 error: function(error) {
                     alert('Erro ao adicionar OS!');
                 }
             });
         });*/
    });


}
function FecharOs(id,idtabela){
  //ao clicar fecher esta os sai da lista de os em andamento e vai para as finalizadas
  if(confirm("Tem certeza que deseja Fechar Os " + idtabela +" ?")){

     $.ajax({
        url: "api/fecharOs/" + id, // A URL com o parâmetro
        method: "GET",                           // Método HTTP
        dataType: "json",
        success: function(response) {
            console.log(response);
           if(response.status == 1) {

              alert(response.message);


            }else{

              alert(response.message);
          }
        },

        error: function(xhr, status, error) {
            alert.error("Erro na requisição:", error);
        }

    });
 }else{
    return false;
 }
}
function listaFotos(id){

    $.ajax({
        url: '/api/SolitaFoto/'+ id,  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.data;
                console.log(dados);
                  $.each(dados, function (i, val) {
                     var id  = val.id;
                     var dadosAntes = val.fotoAntesT;
                     var dadosDurante = val.fotoDuranteT;
                     var dadosDepois = val.fotoDepoisT;
                     var retorno = dadosAntes.split(";");
                     var retornoDurante = dadosDurante.split(";");
                     var retornoDepois = dadosDepois.split(";");
                     $.each(retorno, function (i, te) {
                        let nome = te;
                        let caminhoImagem = "storage/public/image/" + id + "/Antes/" + encodeURIComponent(nome);

                        // Cria a imagem
                        let img = document.createElement('img');
                        img.src = caminhoImagem;
                        img.style.width = "200px";
                        img.style.height = "200px";

                        // Cria o label e define o texto
                        let label = document.createElement('label');
                        label.textContent = 'Foto Antes: ';


                        let container = document.getElementById('arquivo');

                        // Cria o link de download
                        let downloadLink = document.createElement('a');
                        downloadLink.href = caminhoImagem;
                        downloadLink.download = nome;
                        // Cria o texto para o link
                        let linkText = document.createTextNode("Clique para baixar a foto");

                        // Adiciona o texto ao link
                        downloadLink.appendChild(linkText);

                        // Adiciona o label ao container
                        container.appendChild(label);

                        // Adiciona a imagem ao container
                        container.appendChild(img);

                        // Adiciona o link de download ao container
                        container.appendChild(downloadLink);
                });
                $.each(retornoDurante, function (i, tes) {
                    let nome = tes;
                    let caminhoImagem = "storage/public/image/" + id + "/Durante/" + encodeURIComponent(nome);

                    // Cria a imagem
                    let img = document.createElement('img');
                    img.src = caminhoImagem;
                    img.style.width = "200px";
                    img.style.height = "200px";

                    // Cria o label e define o texto
                    let label = document.createElement('label');
                    label.textContent = 'Foto Durante: ';


                    let container = document.getElementById('arquivoD');

                    // Cria o link de download
                    let downloadLink = document.createElement('a');
                    downloadLink.href = caminhoImagem;
                    downloadLink.download = nome;
                    // Cria o texto para o link
                    let linkText = document.createTextNode("Clique para baixar a foto");

                    // Adiciona o texto ao link
                    downloadLink.appendChild(linkText);

                    // Adiciona o label ao container
                    container.appendChild(label);

                    // Adiciona a imagem ao container
                    container.appendChild(img);

                    // Adiciona o link de download ao container
                    container.appendChild(downloadLink);
            });
            $.each(retornoDepois, function (i, tess) {
                let nome = tess;
                let caminhoImagem = "storage/public/image/" + id + "/Depois/" + encodeURIComponent(nome);

                // Cria a imagem
                let img = document.createElement('img');
                img.src = caminhoImagem;
                img.style.width = "200px";
                img.style.height = "200px";

                // Cria o label e define o texto
                let label = document.createElement('label');
                label.textContent = 'Foto Depois: ';


                let container = document.getElementById('arquivoDE');

                // Cria o link de download
                let downloadLink = document.createElement('a');
                downloadLink.href = caminhoImagem;
                downloadLink.download = nome;
                // Cria o texto para o link
                let linkText = document.createTextNode("Clique para baixar a foto");

                // Adiciona o texto ao link
                downloadLink.appendChild(linkText);

                // Adiciona o label ao container
                container.appendChild(label);

                // Adiciona a imagem ao container
                container.appendChild(img);

                // Adiciona o link de download ao container
                container.appendChild(downloadLink);
        });




   });

                $.each(dados, function (i, val) {
                //     // Append tem a função de inserir

                //     var concaternart = (val.item ? val.item : 'Valor não disponível') + '-' + (val.descricao ? val.descricao : 'Descrição não disponível');
                //    /// console.log(concaternart);
                //         $('#produto').append($("<option>", { value: val.id, text: concaternart }));
                //         $('#idDescricao').append($("<input>", { value: val.id, text: val.id }));

                 });

            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });


}

function enviarFormulario(id){
    $.ajax({
        url: "api/excel/" + id, // A URL com o parâmetro
        method: "GET",                           // Método HTTP
       /// dataType: "json",
        xhrFields: {
        responseType: 'blob'  // Diz que a resposta será um arquivo (como Excel)
    },                       // Espera uma resposta no formato JSON
        success: function(response) {

          //  console.log(response);
          if(response.status == 1) {
            alert('Dados Não localizados Por favor preencha envie os dados' );


            }else{
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(response);
                a.href = url;
                a.download = 'LISTA DE MATERIAIS DA MANUTENÇÃO.xlsx';  // Nome do arquivo que será baixado
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);  // Libera o objeto URL
          }
        },

        error: function(xhr, status, error) {
            alert.error("Erro na requisição:", error);
        }

    });



}
function CarregaProdutos() {
  $.ajax({
        url: '/api/ListaProdutos',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.data;

                // $('#material').change(function() {
                //     if ($(this).is(':checked')) {
                //         var checkboxValue = $(this).val();  // Valor da checkbox (Material)
                //         alert('Valor da checkbox: ' + checkboxValue);  }
                // });

                $.each(dados, function (i, val) {
                    // Append tem a função de inserir

                    var concaternart = (val.item ? val.item : 'Valor não disponível') + '-' + (val.descricao ? val.descricao : 'Descrição não disponível');
                   /// console.log(concaternart);
                        $('#produto').append($("<option>", { value: val.id, text: concaternart }));
                        $('#idDescricao').append($("<input>", { value: val.id, text: val.id }));

                 });

            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });

// aqui vou chamar a api do materia e servido
    var count = 1;
    $(document).on('change', '#produto','#idDescricao',function () {
        var selectedOption = $('#produto option:selected');
        $('#nomeProduto' + count).val(selectedOption.text());  // Pega o texto do option selecionado
        $('#idDescricao' + count).val(this.value);
        $('#descricao' + count).val(this.value);
    });

    $(document).on('click', '#Adicionar', function () {
        count++;
        var div = '<div class="d-flex flex-row">';  // Início da div flexbox
         var inputText2 = '<div class="p-2"><label for="nomeProduto">Produto estou adiciando aqui:</label><input type="text" class="form-control" name="nomeProduto' + count + '" id="nomeProduto' + count + '" value=""/></div>';
         var inputText4 = '<input type="hidden" class="form-control" id="idDescricao' + count + '" name="Idproduto' + count + '" value="" />';
         var inputText = '<div class="p-2"><label for="descricao">Quantidade:</label><input type="text" class="form-control" name="quantidade' + count + '" id="quantidade' + count + '" value=""/></div>';
        div += '</div>';
        $('#conteudo').append(div);
        $('#conteudo').append(inputText2);
        $('#conteudo').append(inputText4);
        $('#conteudo').append(inputText);
    });

}
