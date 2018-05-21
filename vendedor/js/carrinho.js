// ----------------- Inicia requisi��o com envio de dados --------------------------//
function enviaDados(act, campo){
    doc = document.getElementById(campo).value;
    params = '&modelo=' + doc;
    acao =  act;
    requisicaoHttp('../php/pesquisarMovel.php', "acao=" + acao + params);
}

function excluirDoCarrinho(codigoMovel){
    acao="excluir";
    if(confirm("Você deseja excluir este móvel do carrinho de compras?")){
        cliente = document.getElementById("cpf").value;
        params = 'acao=excluir' + '&cliente=' + cliente + "&movel=" + codigoMovel;
        requisicaoHttp('../php/excluirDoCarrinho.php', params);
    } else {
        document.getElementById("chkbx").checked = false;
    }
}

function calcularTotal(){
    acao = "calcularDesconto";
    desconto = document.getElementById("desconto");
    valorTotal = document.getElementById("valorTotal");
    total = document.getElementById("total");
    params = 'acao=' + acao + '&desconto=' + desconto.value + '&total=' + total.value;
    requisicaoHttp('../php/excluirDoCarrinho.php', params);
}

function salvar(){
    acao="salvar";
    var cliente = document.getElementById("cpf").value;
    var desconto = document.getElementById("desconto").value;
    var total = document.getElementById("valorTotal").value;
    var endereco = document.getElementById("enderecoEntrega").value;
    var referencia = document.getElementById("refEntrega").value;
    var params = "cliente=" + cliente + "&desconto=" + desconto + "&valorTotal=" + total + "&endereco=" + endereco + "&referencia=" + referencia;

    requisicaoHttp('../php/registrarCompra.php', params);
}

function trataDados() {
    if(acao=="excluir"){
        location.reload();
    } else if(acao=="calcularDesconto"){
        valorTotal.value = ajax.responseText;
    } else if(acao=="salvar"){
            xml = ajax.responseText;
            
            msg = xml.split(" ");
            
        if(msg[1] == "ok") {
            alert("Compra efetuada com sucesso. Você será redirecionado para a página de pagamento.");
            window.location = "pagamento.php?id=" + msg[0];
        } else {
            alert (xml);
        }
    }
    
    acao = "";
}