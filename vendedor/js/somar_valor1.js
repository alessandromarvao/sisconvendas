// ----------------- Inicia requisição com envio de dados --------------------------//
function enviaDados(act, campo1, campo2){
    qtde = document.getElementById(campo1).value;
    valor = document.getElementById(campo2).value;
    params = '&qtde=' + qtde + '&valor=' + valor;
    acao =  act;
    requisicaoHttp('../php/calcularValor.php', "acao=" + acao + params);
}

function carregar(){
    acao = "carregarPagina";
    var id = "&id=" + window.location.href.split("?id=")[1];
    requisicaoHttp('../php/calcularValor.php', "acao=" + acao + id);
}

function carregarTotal(){
    var qtde = document.getElementById("qtde").value;
    var valor = document.getElementById("valor").value;
    acao="somarTotal";
    var params = "&qtde=" + qtde + "&valor=" + valor;
    
    requisicaoHttp('../php/calcularValor.php', "acao=somar" + params);
}

function salvar(){
    acao="salvar";
    var cliente = document.getElementById("cpf").value;
    var movel = document.getElementById("id").value;
    var qtde = parseInt(document.getElementById("qtde").value);
    var valor = document.getElementById("valor").value;
    var entrega = document.getElementById("entrega").value;
    var montagem = document.getElementById("montagem").value;
    var limite = parseInt(document.getElementById("qtde_limite").value);
    var campo_data_entrega = "";
    var campo_data_montagem = "";
    
    if(entrega==1){
        var campoEndereco = document.getElementById("endereco").value;
        var campoReferencia = document.getElementById("referencia").value;
        campo_data_entrega = document.getElementById("data_entrega").value;
    }
    if(montagem==1){
        campo_data_montagem = document.getElementById("data_montagem").value;
    }
    if(qtde=="" || qtde==0){
        alert("Você esqueceu de citar a quantidade desejada");
    } else if(qtde>limite && limite>0) {
        alert("Quantidade selecionada excede o estoque (" + limite + ").");
    } else if(qtde<=limite) {
        var status = "fail";
        params = "cliente=" + cliente + "&movel=" + movel + "&qtde=" + qtde + "&valor=" + valor + "&montagem=" + montagem + "&entrega=" + entrega;
        if(entrega==1 || montagem==1){ //confere se há entrega e montagem do(s) móvel(is)
            if(entrega==1 && campo_data_entrega!==""){
                params += "&endereco=" + campoEndereco + "&ref=" + campoReferencia + "&data_entrega=" + campo_data_entrega;
                status = "ok";
//                requisicaoHttp('../php/adicionarNoCarrinho.php', params);
            } else if(entrega==1 && campo_data_entrega=="") {
                alert("Você deve preencher a data da entrega!");
                status = "fail";
            }
            
            if(montagem==1 && campo_data_montagem!==""){
                params += "&data_montagem=" + campo_data_montagem;
                status = "ok";
            } else if(montagem==1 && campo_data_montagem=="") {
                alert("Você deve preencher a data da montagem!");
                status = "fail";
            }
        } else {
            status = "ok";
        }
        if(status=="ok"){
            requisicaoHttp('../php/adicionarNoCarrinho.php', params);
        }
    } else if(isNaN(limite)==true || limite==0){
        var pergunta = confirm("Produto indisponível no estoque. \nVocê deseja realizar o pedido do mesmo?");
        if(pergunta==true){
            params = "cliente=" + cliente + "&movel=" + movel + "&qtde=" + qtde + "&valor=" + valor + "&montagem=" + montagem + "&entrega=" + entrega;
            var status = "fail";
            
            if(entrega==0 && montagem==0){
                status = "ok";
            }
            
            if(entrega==1){
                if(campo_data_entrega!==""){
                    params += "&endereco=" + campoEndereco + "&data_entrega=" + campo_data_entrega;
                    status = "ok";
//                    requisicaoHttp('../php/adicionarNoCarrinho.php', params);
                } else {
                    alert("Você esqueceu de digitar a data de entrega!");
                    status = "fail";
                }
            }
            if(montagem==1){
                if(campo_data_montagem!==""){
                    params += "&data_montagem=" + campo_data_montagem;
                    status = "ok";
                } else {
                    alert("Você esqueceu de digitar a data da montagem!");
                    status = "fail";
                }
            }
            
            if(status=="ok"){
                requisicaoHttp('../php/adicionarNoCarrinho.php', params);
            }
        }
    } else {
        alert("Você esqueceu de citar a quantidade desejada aqui");
    }
    
}

function alterarValor(campo){
    var campos = document.getElementById(campo);
    var entrega = document.getElementById("campo_entrega");
    var montagem = document.getElementById("campo_montagem");
    var valor = campos.value;
    if(valor==0){
        campos.value = 1;
        valor=1;
    } else if(valor==1) {
        campos.value = 0;
        valor=0;
    }
    switch(campo){
        case "entrega":
            if(valor==1){
                acao="criarEndereco";
                params = "acao=" + acao;
                requisicaoHttp('../php/calcularValor.php', params);
            } else {
                entrega.innerHTML = "";
            }
            break;
        case "montagem":
            if(valor==1){
                var texto = "<label>Data da Montagem:</label>";
                texto += "<input type='date' id='data_montagem' class='form-control' />";
                montagem.innerHTML = texto;
            } else {
                montagem.innerHTML = "";
            }
            break;
    }
    campo="";
}

function trataDados() {
    if(acao=="carregar"){
        
    } else if(acao=="somar"){
        var div = document.getElementById("total");
        xml = ajax.responseText;
        div.value = xml;
    } else if(acao=="salvar") {
        xml = ajax.responseText;
        array = xml.split(" ");
        if(array[0]=="ok"){
            $resposta = confirm("Móvel adicionado ao carrinho de compras. \nClique em OK para ir à página de confirmação de venda ou CANCELAR para selecionar outro móvel.");
            if($resposta == true){
                window.location = "carrinho_compras.php";
            } else {
                window.location = "pesquisar_movel.php?id=" + array[1];
            }
        } else{
            alert("Falha ao salvar no carrinho. Verifique os dados informados e tente novamente.");
        }
    } else if(acao=="criarEndereco"){
        var endereco = document.getElementById("campo_entrega");
        var end = ajax.responseXML.documentElement.getElementsByTagName("endereco")[0].firstChild.nodeValue;
        var referencia = ajax.responseXML.documentElement.getElementsByTagName("referencia")[0].firstChild.nodeValue;
        var texto = "<label>Data da Entrega:</label>\n";
        texto += "<input type='date' class='form-control' id='data_entrega' />\n";
        texto += "<br/><label>Endereço para entrega:</label>\n";
        texto += "<input type='text' class='form-control' value='" + end + "' id='endereco' /><br/>";
        texto += "<label>Ponto de referência:</label>\n";
        texto += "<input type='text' class='form-control' value='" + referencia + "' id='referencia' />"
        endereco.innerHTML = texto;
    } else if(acao=="somarTotal"){
        var total = document.getElementById("total");
        total.value = ajax.responseText;
    }
}