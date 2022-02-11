// app.js

function adicionar_carrinho(id_produto) {

    axios.defaults.withCredentials = true;
    axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
        .then(function(response){
            var total_produtos = response.data;
            document.getElementById('carrinho').innerText = total_produtos;
        });

}

//===================================================================================
function limpar_carrinho() {
    var e = document.getElementById("confirmar_limpar_carrinho");
    e.style.display = "inline";
}

//===================================================================================
function limpar_carrinho_off() {
    var e = document.getElementById("confirmar_limpar_carrinho");
    e.style.display = "none";
}

//===================================================================================
function usar_endereco_alternativo() {
    // Mostrar formulário para preenchimento do endereço alternativo
    var e = document.getElementById('check_endereco_alternativo');

    if(e.checked == true) {

        // Mostra o formulário para definir o endereço alternativo
        document.getElementById('endereco_alternativo').style.display = 'block';

    } else {

        document.getElementById('endereco_alternativo').style.display = 'none';

    }

}


//===================================================================================
function definir_endereco_alternativo() {

    axios({
        method: 'post',
        url: '?a=definir_endereco_alternativo',
        data: {
            text_nome: document.getElementById('text_nome_alternativo').value,
            text_endereco: document.getElementById('text_endereco_alternativo').value,
            text_cidade: document.getElementById('text_cidade_alternativo').value,
            text_telefone: document.getElementById('text_telefone_alternativo').value
        }

    }).then(function(response){
        console.log('OK');
    })

}
