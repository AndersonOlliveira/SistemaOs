const { data } = require("autoprefixer");

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
                url: '/api/ListaOs',  // URL da API
                dataSrc: ''  // Define que a resposta será um array (sem chave para acessar)
            },
            columns: [
                { data: 'id' },
                { data: 'Equipe' },
                { data: 'data' },
                { data: 'NomeCluster' },
                { data: 'endereco' },
                { data: 'tipoOs' },
                { data: 'hoInicio' },
                { data: 'horFim' },
                { data: 'solClaro' },
                { data: 'Prefixo' }
            ]
        });
    });

    $.ajax({
        url: 'api/ListaOs',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.Status == 2) {
               var dados =  response.result;

               console.log(dados);
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
