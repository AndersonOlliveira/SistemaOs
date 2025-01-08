
function exibirCaixaTexto(botao) {
    var caixaTexto = botao.nextElementSibling; //colocando === para retornar se não do mesmo tipo e do mesmo operador
    if(caixaTexto.style.display === "none" || caixaTexto.style.display === ""){
      caixaTexto.style.display = "block"; // Mostra a caixa de texto
        botao.textContent = "Fechar Caixa de Texto";
    } else {
        caixaTexto.style.display = "none"; // Oculta a caixa de texto
        botao.textContent = "";
    }
}

function criarInputsDinamicos(quantidade) {
    const container = document.getElementById('inputsDinamicosContainer');
    container.innerHTML = ''; // Limpar o conteúdo anterior

    for (let i = 1; i <= quantidade; i++) {
      const input = document.createElement('input');
      input.type = 'text';
      input.name = `input${i}`;
      input.placeholder = `Input ${i}`;
      input.className = 'dynamic-input';
      container.appendChild(input);
    }
  }