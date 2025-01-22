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

       alert('Dados Não localizados Por favor preencha envie os dados' );

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



function CarregaOs() {

    $(document).ready(function () {
        $('#listaOs').DataTable({
            scrollX: true,
            ajax: {
                url: '/api/ListaOs',
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
                { data: 'Prefixo' },
                { // Coluna para os botões
                    data: null,
                    render: function (data, type, row) {

                         if(row.fotoAntes == null){
                        return '<button class="btn btn-warning btnEditar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '"  data-target=".bd-example-modal-lg">Complentar Os</button>';

                        }else if(row.omClaro == null){
                             return '<button class="btn btn-info btnCompletar" data-id="' + row.id + '" data-nome="' + row.NomeCluster + '" data-unico="' + row.idUnicoCluster + '"  data-target=".bd-example-modal-lg">Inserir Om ,Os Claro </button>';

                        }else{
                            return '<button class="btn btn-info" onclick="enviarFormulario(' + row.idUnicoCluster + ')">Solicitar Execell</button>';

                        }
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
            $('#idCluster').val(rowId);
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
            $('#idCluster').val(rowId);
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
            $('#idUnico').val(rowIdUnico);
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
function enviarFormulario(id){
    $.ajax({
        url: "api/excel/" + id, // A URL com o parâmetro
        method: "GET",                           // Método HTTP
       /// dataType: "json",
        xhrFields: {
        responseType: 'blob'  // Diz que a resposta será um arquivo (como Excel)
    },                       // Espera uma resposta no formato JSON
        success: function(response) {

            console.log(response);
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
