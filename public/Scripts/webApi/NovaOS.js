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
