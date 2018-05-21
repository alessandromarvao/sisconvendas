var acao = "";
var tem_entrega = 0;
var tem_montagem = 0;
var params;

var carregarTotal = function(){
    var qtde = document.getElementById("qtde").value;
    var valor = document.getElementById("valor").value;
    acao="somarTotal";
    var params = "&qtde=" + qtde + "&valor=" + valor;
    
    requisicaoHttp('../php/calcularValor.php', "acao=somar" + params);
};

var alterarValor = function(campo){
    var checklist = document.getElementById(campo);
    var entrega = document.getElementById("campo_entrega");
    var montagem = document.getElementById("campo_montagem");
    
    if(checklist.value==0){
        checklist.value = 1;
    } else if(checklist.value==1){
        checklist.value = 0;
    }
    
    switch(campo){
        case "entrega":
            if(checklist.value==1){
                acao="criarEndereco";
                params = "acao=" + acao;
                requisicaoHttp('../php/calcularValor.php', params);
            } else {
                entrega.innerHTML = "";
            }
            break;
        case "montagem":
            var texto = "";
            if(checklist.value==1){
                texto += "<br />";
                texto += "<label class='col-xs-12'>Data da Montagem:";
                texto += "<input type='date' id='data_montagem' class='form-control' /><br/>";
                texto += "</label>";
            }
            montagem.innerHTML = texto;
            break;
    }
};

var salvar = function(){
    var qtde = parseInt(document.getElementById("qtde").value); //quantidade comprada
    var limite = parseInt(document.getElementById("qtde_limite").value); //quantidade do estoque
    
    if(qtde=="" || qtde==0){ //n�o existe a quantidade comprada.
        alert("Você esqueceu de citar a quantidade comprada!");
    } else if(qtde>limite && limite>0){ //quantidade comprada excede o estoque.
        alert("Quantidade selecionada excede o estoque (" + limite + ").");
    } else if(isNaN(limite)==true || limite==0){ //n�o existe estoque do mesmo.
        var pergunta = confirm("Produto indisponível no estoque. \nVocê deseja realizar o pedido do mesmo?"); //confere se o usu�rio deseja fazer o pedido do m�vel desejado.
        
        if(pergunta == true){ //caso o usu�rio realizar o pedido do m�vel.
            realizar_compra(qtde);
        }
    } else if(limite>=qtde){ //quantidade comprada � menor que o estoque.
        realizar_compra(qtde);
    }
};

var realizar_compra = function(qtde){ //cadastra no BD a compra do m�vel desejado e sua quantidade comprada.
    var cliente = document.getElementById("cpf").value;
    var movel = document.getElementById("id").value;
    var valor = document.getElementById("valor").value;
    var entrega = document.getElementById("entrega").value;
    var montagem = document.getElementById("montagem").value;
    
    params = "cliente=" + cliente + "&movel=" + movel + "&qtde=" + qtde + "&valor=" + valor + "&montagem=" + montagem + "&entrega=" + entrega;

    if(confere_campos(entrega, montagem)){
        acao = "salvar";
        requisicaoHttp('../php/adicionarNoCarrinho.php', params);
    }
};

var confere_campos = function(entrega, montagem){ //confere se existe montagem e/ou entrega
    //confere entrega e montagem
    if(entrega==0 && montagem==0){
        return true;
    } else {
        var bool_montagem = true;
        var bool_entrega = true;
        if(entrega==1){
            var data_entrega = document.getElementById("data_entrega").value;
            if(data_entrega!==""){
                params += "&data_entrega=" + data_entrega; //armazena a data de entrega nos par�metros
            } else {
                alert("Você deve preencher a data da entrega!");
                bool_entrega = false;
            }
        }
        if(montagem==1){
            var data_montagem = document.getElementById("data_montagem").value;
            if(data_montagem!==""){
                params += "&data_montagem=" + data_montagem; //armazena a data de montagem nos par�metros
            } else {
                alert("Você deve preencher a data da montagem!");
                bool_montagem = false;
            }
        }
        
        if(bool_entrega==true && bool_montagem==true){ //confere se a entrega e montagem est�o com as datas preenchidas
            return true;
        } else {
            return false;
        }
    }
};

var criarEndereco = function(end, ref){
    var campo_entrega = document.getElementById("campo_entrega");
    var texto = "<br/>";
    texto += "<label class='col-xs-12'>Data da Entrega:\n";
    texto += "<input type='date' class='form-control' id='data_entrega' />\n";
    texto += "</label>";
    texto += "<label class='col-xs-12'>Endereço para entrega:\n";
    texto += "<input type='text' class='form-control' value='" + end + "' id='endereco' />\n";
    texto += "</label>";
    texto += "<label class='col-xs-12'>Ponto de referência:\n";
    texto += "<input type='text' class='form-control' value='" + ref + "' id='referencia' /><br />\n";
    texto += "</label>";
    campo_entrega.innerHTML = texto;
    return 0;
};

function trataDados(){
    switch(acao){
        case "somarTotal":
            var total = document.getElementById("total");
            total.value = ajax.responseText;
            break;
        case "criarEndereco":
            var endereco = ajax.responseXML.documentElement.getElementsByTagName("endereco")[0].firstChild.nodeValue;
            var referencia = ajax.responseXML.documentElement.getElementsByTagName("referencia")[0].firstChild.nodeValue;
            criarEndereco(endereco, referencia);
            break;
        case "salvar":
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
            break;
    }
}