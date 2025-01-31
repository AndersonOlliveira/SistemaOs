var MvcController = new function () {
    this.Call = function Call(_type, _url, _dataType, _param, _method) {
        ///CarregaClasses();
        StarLoad();
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
    CarregaClasses();
});
function StarLoad() {
    // Exibe a barra de progresso
 $("#progress").show();

    // Simula o carregamento progressivo (0 a 100%)
    var percentage = 0;
    var interval = setInterval(function() {
        if (percentage < 100) {
            percentage += 10;  // Aumenta o progresso em 10%
            updateProgressBar(percentage);
        } else {
            clearInterval(interval);  // Para quando chegar a 100%
            setTimeout(StopLoad, 1000); // Chama StopLoad após 1 segundo
        }
    }, 1000);  // Atualiza a cada segundo
}

// function CarregaClasses() {
//     $(document).ready(function () {
//         var table = $('#classes').DataTable({
//             scrollX: true,
//              ajax: {
//                 url: 'api/ApiClasse',
//                 // method:'get', // URL da API
//                 dataSrc: 'data',  // Define que a resposta será um array (sem chave para acessar)
//             },
//              columns: [
//                 { data: 'id' },
//                 { data: 'tipoOs' },
//                 { data: 'idClasseOs' },
//                 {
//                     data: null,
//                     render: function (data, type, row) {
//                         var buttons = '';
//                         buttons += '<button class="btn btn-success">Solicitar Excel</button> ';

//                         return buttons;
//                     },
//                 }
//             ]
//         });

//         console.log(table);

//     });

// }
function CarregaClasses() {
    $.ajax({
        url: 'api/ApiClasse',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.result;
                montarTabela(dados);
            } else {
                alert(response.Result);
            }
        },
        error: function (xhr, status, error) {
            console.log("Erro ao carregar cluster: " + error);
        }
    });
}

function montarTabela(dados){
    tabelaData =[];
     $.each(dados, function (i, val) {

         tabelaData.push({
            id: val.id,
            tipoOs: val.tipoOs,
            idClasseOs: val.idClasseOs,

        });
    });

    $('#classes').DataTable({
        data: tabelaData,
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
            { data: 'tipoOs' },
            { data: 'idClasseOs' },
            {
                data: null,
                render: function (data, type, row) {

                   var buttons = '';

                    buttons += '<button class="btn btn-info btnEnviar" data-id="' + row.id + '" data-nome="' + row.tipoOs + '" data-unico="' + row.idClasseOs + '" data-target=".bd-example-modal-lg">Enviar Planilha</button> ';


                  return buttons;
            }

            }
           ]
    });
    $('#classes tbody').on('click', '.btnEnviar', function () {
        var rowId = $(this).data('id');
        var rowIdUnico = $(this).data('unico');
        //console.log(rowIdUnico);
        var nomeClasse = $(this).data('nome');
        // Aqui você pode preencher o formulário do modal com os dados da linha
        $('#campoClasse').val(nomeClasse);
        $('#idClasse').val(rowId);
        $('#idUnioClasse').val(rowIdUnico);
        //preenchêr campos

        // chama o modal
        $('#modalEnvioPlanilha').modal('show');
        // $('#modalServicos').modal('show');
    });

}


