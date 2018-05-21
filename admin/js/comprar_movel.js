function carregarPagina(){
    acao = "carregarPagina";
    
    idMovel = document.getElementById("idMovel").value;
    campoImagem = document.getElementById("campoImagem");
    campoModelo = document.getElementById("campoModelo");
    campoValor = document.getElementById("campoValor");
    
    param="acao=" + acao + "&idMovel=" + idMovel;
    requisicaoHttp("../php/cadastrar_compra.php", param);
}

function salvar(){
    acao = "salvar";
    idMovel = document.getElementById("idMovel").value;
    valor = document.getElementById("campoValor");
    qtde = document.getElementById("campoQtde");
    if(qtde.value==""){
        alert("Você deve citar o valor do móvel.");
        qtde.focus(true);
    } else if(valor.value==""){
        alert("Você deve citar a quantidade do móvel comprada.");
        valor.focus(true);
    } else {
        param = "acao=" + acao + "&idMovel=" + idMovel + "&qtde=" + qtde.value + "&valor=" + valor.value;
        requisicaoHttp("../php/cadastrar_compra.php", param);
    }
}

function trataDados(){
    if(acao == "carregarPagina"){
        estaVazio = ajax.responseXML.documentElement.getElementsByTagName("vazio")[0].firstChild.nodeValue;
        
        if(estaVazio=="s"){
            alert("Nenhum móvel selecionado.");
            window.location = "index.php";
        } else {
            resposta = ajax.responseXML.documentElement.getElementsByTagName("movel");
            //armazena o modelo do m�vel
            modelo = resposta[0].getElementsByTagName("modelo")[0].firstChild.nodeValue;
            marca = resposta[0].getElementsByTagName("marca")[0].firstChild.nodeValue;
            campoModelo.innerHTML = "<h3>" + modelo + " " + marca + "</h3>\n";
            //armazena o valor da compra no campo
            campoValor.value = resposta[0].getElementsByTagName("valor")[0].firstChild.nodeValue;
            //armazena o endere�o da imagem do móvel
            imagem = resposta[0].getElementsByTagName("imagem")[0].firstChild.nodeValue;
            campoImagem.innerHTML = "<img src='" + imagem + "' style='width: 100%' />"
        }
    } else if(acao=="salvar"){
        resposta = ajax.responseText;
        if(resposta=="ok"){
            alert("Compra registrada e quantidade adicionada ao estoque.");
            window.location = "index.php";
        } else{
            alert(resposta);
            window.location = "index.php";
        }
    }
}