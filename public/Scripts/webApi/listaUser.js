var MvcController = new function () {
    this.Call = function Call(_type, _url, _dataType, _param, _method) {
        CarregarUsers();
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
    CarregarUsers();
});
function CarregarUsers(){
    $.ajax({
        url: 'api/ListaUsuarios',  // Rota criada em Laravel
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.Status == 2) {
                var dados = response.data;
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
            name: val.name,
            email: val.email,
            login: val.login,
            // nivel: val.nivel,
            tipoUser: val.tipoUser,

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
            { data: 'name' },
            { data: 'email' },
            { data: 'login' },
            // { data: 'nivel' },
            { data: 'tipoUser' },
            {
                data: null,
                render: function (data, type, row) {

                   var buttons = '';

                    buttons += '<button class="btn btn-info btnEditarSenha" data-id="' + row.id + '" data-nome="' + row.tipoOs + '" data-unico="' + row.idClasseOs + '" data-target=".bd-example-modal-lg">Editar Senha</button> ';


                  return buttons;
            }

            }
           ]
    });
    $('#classes tbody').on('click', '.btnEditarSenha', function () {
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
        $('#modalTrocaSenha').modal('show');
        // $('#modalServicos').modal('show');
    });
}
