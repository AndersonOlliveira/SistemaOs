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
console.log('acessei o java script');

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

function updateProgressBar(percentage) {
    // Atualiza a barra de progresso
    $("#progressBar").css("width", percentage + "%");
    $("#progressBar").attr("aria-valuenow", percentage);
    $("#progressText").text("Carregando... " + percentage + "%");
}

function StopLoad() {
    // Esconde a barra de progresso
    $("#progress").hide();
}
