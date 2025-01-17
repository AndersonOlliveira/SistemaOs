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
   $.ajax({
    url: "api/Listateste/" + rowId + '/' + rowIdUnico, // A URL com o parâmetro
    method: "GET",                           // Método HTTP
    dataType: "json",                        // Espera uma resposta no formato JSON
    success: function(response) {
      if(response.status == 1) {

         alert(response.dados);

        }else{
          var dados = response.dados
            montarTabela(dados);
           // Exibe a resposta no console

      }
    },

    error: function(xhr, status, error) {
        alert.error("Erro na requisição:", error);
    }

});

function montarTabela(dados){
     tabelaData = [];
   $.each(dados, function (i, val) {
        // Append tem a função de inserir
         // Adicionando os dados no array para preencher a tabela
         var items = val.item;
         var descricoes = val.descricao;
         var itemComDescription = items.concat('-' + descricoes);
         $('#staticBackdrop').modal('show');
         tabelaData.push({
            id: val.id,
            descripion: itemComDescription,
            valor: val.valor,
            quantidade: val.QuantidadeProd
        });
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
            { data: 'quantidade' }
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



function CarregaOs() {

    $(document).ready(function () {
        $('#listaOs').DataTable({
            ajax: {
                url: '/api/ListaOs',
                // method:'get', // URL da API
                dataSrc: 'data',  // Define que a resposta será um array (sem chave para acessar)
                scrollX : true,
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
                { data: 'Prefixo' },
                { // Coluna para os botões
                    data: null,
                    render: function (data, type, row) {
                        return '<button class="btn btn-warning btnEditar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '"  data-target=".bd-example-modal-lg">Complentar Os</button>';
                    }


                },
                { // Coluna para os botões
                    data: null,
                    render: function (data, type, row) {
                        return '<button class="btn btn-secondary btnServicos" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Adiconar Serviços </button>';
                    }
                }, { // Coluna para os botões
                    data: null,
                    render: function (data, type, row) {
                        return '<button class="btn btn-info btnDados" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '" data-target=".bd-example-modal-lg">Listar Dados</button>';
                    }
                },
                // { // Coluna para os botões
                //      data: null,
                //     render: function (data, type, row) {
                //         return '<input type="hidden" data-idunicocluster="' + row.idUnicoCluster + '"  data-target=".bd-example-modal-lg"/>';
                //      }
                //  },
            ]
        });

        // Evento para abrir o modal ao clicar no botão "Editar"
        $('#listaOs tbody').on('click', '.btnEditar', function () {
            var rowId = $(this).data('id');
            var rowIdUnico = $(this).data('unico');
            //console.log(rowIdUnico);
            var nomeCluster = $(this).data('nome');
            // Aqui você pode preencher o formulário do modal com os dados da linha
            $('#campoNome').val(nomeCluster);
            $('#idos').val(rowId);
            $('#idUnico').val(rowIdUnico);
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
            $('#idos').val(rowId);
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
            $('#idos').val(rowId);
            $('#idUnicos').val(rowIdUnico);
            //preenchêr campos

            // chama o modal


             ListarDadosRota(rowId,rowIdUnico);
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
function CarregaProdutos() {


    $.ajax({
        url: '/api/ListaProdutos',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.data;
                //console.log(dados);
                // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
                $.each(dados, function (i, val) {

                   // Append tem a função de inserir

                    $('#produto').append($("<option>", { value: val.id, text: val.descricao }));
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
        var inputText2 = '<br><label for="nomeProduto">Produto estou adiciando aqui:</label><input type="text" class="form-control" name="nomeProduto' + count + '" id="nomeProduto' + count + '" value=""/>';
        var inputText4 = '<br> <input type="hidden" class="form-control" id="idDescricao' + count + '" name="Idproduto' + count + '" value="" />';
        var inputText = '<br><label for="descricao">Quantidade:</label><input type="text" class="form-control" name="quantidade' + count + '" id="quantidade' + count + '" value=""/>';


        $('#conteudo').append(inputText2);
        $('#conteudo').append(inputText4);
        $('#conteudo').append(inputText);
    });

}
