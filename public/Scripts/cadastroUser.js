var MvcController = new function () {
    this.Call = function Call(_type, _url, _dataType, _param, _method) {
        CarregaCidades();
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

  function CarregaCidades() {
        $.ajax({
            url: 'api/cidades',  // Rota criada em Laravel
            type: 'GET',
            dataType: 'json',

            success: function(response) {
                if (response.Status == 2) {


                   // console.log(response.message);

                     liberaEstado(response.message);



                    $('#selectCidade').append($('<option>', { value: '', text: 'Todas as Cidades' }));
                    // Adiciona as outras opções

                   //  $.each(response.message, function (i, item) {


                     //   $('#selectCidade').append($('<option>', { value: item.id, text: item.cidade }));
                   // });
                } else {
                   // alert(response.Result);
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro ao carregar cidades: " + error);
            }
        });
    }

    // Chama a função quando a página for carregada

    $(document).ready(function() {
        CarregaCidades();
    });


    function liberaEstado(response){

        populateUFSelect(response);


    }

    // Função para popular o dropdown de estados
  function populateUFSelect(response) {

     var ufSelect = document.getElementById('uf');
     var ufSet = new Set();

     response.forEach(function(item) {
         ufSet.add(item.uf);
      });

       ufSet.forEach(function(uf) {
         var option = document.createElement('option');

         option.value = uf;
         option.text = uf;
         ufSelect.add(option);
         });
 }
 // Função para popular o dropdown de cidades
 function populateCidadeSelect(uf) {

    if(uf.length >0 ){

    var cidadeSelect = document.getElementById('selectCidade');
     cidadeSelect.innerHTML = "<option selected>Selecione a Cidade</option>";

     response.forEach(function(item) {
        // console.log(uf);
         if (item.uf == uf) {
             var option = document.createElement('option');
             option.value = item.cidade;
             option.text = item.cidade;
             cidadeSelect.add(option);
         }
     });
    }
 }


 document.addEventListener('DOMContentLoaded', function() {
       //populateUFSelect(response.message);

     document.getElementById('uf').addEventListener('change', function() {
      var selectedUF = this.value;
        populateCidadeSelect(selectedUF);
     });
 });
