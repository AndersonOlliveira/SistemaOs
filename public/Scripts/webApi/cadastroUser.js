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
                   var ufSelect = document.getElementById('uf');
                    var ufSet = new Set();
                       response.message.forEach(function(item) {
                       ufSet.add(item.uf);
                    });
                    var ufArray = Array.from(ufSet).sort();
                    ufArray.forEach(function(uf) {
                     var option = document.createElement('option');
                       option.value = uf;
                       option.text = uf;
                       ufSelect.add(option);
                });
                var ufSelecionada = $('#uf').val();
                  if(ufSelecionada.length > 0 ){



               var cidadeSelect = document.getElementById('selectCidade');
                     cidadeSelect.innerHTML = "<option selected> Selecione a Cidade</option>";
                       response.message.forEach(function(item) {
                           if (item.uf == ufSelecionada) {
                             var option = document.createElement('option');
                             option.value = item.cidade;
                             option.text = item.cidade;
                             cidadeSelect.add(option);
                         }
                     });
                }
                 } else {
                    alert(response.Result);
                }
            },
              error: function(xhr, status, error) {
                console.log("Erro ao carregar cidades: " + error);
            }
        });
    }


    $(document).ready(function() {
        CarregaCidades();
    });
    $(document).ready(function() {
        CarregaClusters();
    });
function CarregaClusters() {
    $.ajax({
        url: 'api/ApiCluster',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.Status == 2) {
               var dados =  response.result;
                MontarTabela(dados);
            // console.log(response);
             } else {
                alert(response.Result);
            }
        },
          error: function(xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });
}

function MontarTabela(dados){
    if(dados.length > 0) {
     dados.forEach(function (item) {
const date = new Date(item.created_at);
const formattedDate = moment(date).format('DD/MM/YYYY');
//precisa do moment biblioteca
   $('#clusterListis tbody').append(
            `<tr>
                <td>${item.id}</td>
                <td>${item.NomeCluster}</td>
                <td>${formattedDate}</td>

                 <td><input type='submit' name='deletar' class='btn btn-danger' onclick="deletarRota(${item.id});" value='Deletar'/></td>
            </tr>`
        );
    });
}else{
    $('#clusterListis tbody').append(
        `<tr>
            <td>*</td>
            <td>*</td>
            <td>*</td>
            <td>*</td>

        </tr>`
    );
}
    // Inicializar o DataTable
    $('#clusterListis').DataTable()


}

function deletarRota(id){

     //preparar para deletar, porem vou somente preencher o campo com o dh exclusão.
}
