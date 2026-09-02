    // Fica escutando cada tecla que você digita no campo de busca
    document.getElementById('inputBusca').addEventListener('keyup', function() {

    let termoDigitado = this.value.toLowerCase(); // Transforma o que você digitou em minúsculo
    let linhasDaTabela = document.querySelectorAll('table tbody tr'); // Pega todas as linhas da tabela

    // Passa por cada linha da tabela
    linhasDaTabela.forEach(function(linha) {
        let textoDaLinha = linha.textContent.toLowerCase(); // Pega o texto inteiro da linha

        // Se o texto da linha contiver o que foi digitado, mostra. Se não, esconde.
        if (textoDaLinha.includes(termoDigitado)) {
        linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
});
