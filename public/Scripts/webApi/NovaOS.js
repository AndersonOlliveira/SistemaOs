//const { data } = require("autoprefixer");

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
$(document).ready(function() {
    CarregaClusters();
});
$(document).ready(function() {
    CarregaClasses();
});
$(document).ready(function() {
    CarregaOs();
});
function CarregaClusters() {
$.ajax({
    url: 'api/ApiCluster',  // Rota criada em Laravel
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        if (response.Status == 2) {
           var dados =  response.result;

         /*.log(response);*/
        // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
         $.each(dados, function(i, val){
            // Append tem a função de inserir

            $('#clusters').append($("<option>" ,{ name:'cluster', value: val.id, text: val.NomeCluster }));
        });
         } else {
            alert(response.Result);
        }
    },
      error: function(xhr, status, error) {
        console.log("Erro ao carregar cluster: " + error);
    }
});

}


function CarregaClasses(){
    $.ajax({
        url: 'api/ApiClasse',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.Status == 2) {
               var dados =  response.result;
            // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
             $.each(dados, function(i, val){
                // Append tem a função de inserir
                $('#classes').append($("<option>" ,{  value: val.id, text: val.tipoOs }));
            });
             } else {
                alert(response.Result);
            }
        },
          error: function(xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });
}


function CarregaOs(){

    $(document).ready(function() {
        $('#listaOs').DataTable({
            ajax: {
                url: '/api/ListaOs',
               // method:'get', // URL da API
                dataSrc: 'data'  // Define que a resposta será um array (sem chave para acessar)
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
                    render: function(data, type, row) {
                        return '<button class="btnEnviar" data-id="'+ row.id +'">Enviar</button>';
                    }
                }
            ]
        });

    //     // Evento de clique para botões de "Enviar"
       $('#listaOs tbody').on('click', '.btnEnviar', function() {
             var rowId = $(this).data('id');  // Pega o ID da linha correspondente

             alert(rowId);

    //         // Coletar dados dessa linha, ou enviar para uma API
             $.ajax({
                 url: '/api/enviarInformacoes',
                 method: 'POST',
                 data: {
                     id: rowId,  // Envia o ID da linha
                     _token: '{{ csrf_token() }}'  // Exemplo de token CSRF (se necessário)
                 },
                 success: function(response) {
                     alert('Informações enviadas para o ID: ' + rowId);
                 },
                 error: function(error) {
                     alert('Erro ao enviar informações!');
                 }
             });
         });
    });

    $.ajax({
        url: 'api/ListaOs',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.Status == 2) {

               var dados =  response.data;


            // $('#clusters').append($("<option>" ,{ value: '',  text: 'Selecione Cluster'}));
             $.each(dados, function(i, val){
                // Append tem a função de inserir
                $('#classes').append($("<option>" ,{  value: val.id, text: val.tipoOs }));
            });
             } else {
                alert(response.Result);
            }
        },
          error: function(xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });
}
