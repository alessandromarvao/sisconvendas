var imprimir = function(){
    window.print();
}

var cancelar = function (){
    window.location = "redirecionar.php";
};

function carregarNotas(){
    acao = "carregarPagina";
    var notaVenda = document.getElementById("id_venda").value;
    
    var params = "idVenda=" + notaVenda;
    
    requisicaoHttp("emitirNotasEntregaEMontagem.php", params);
}

function trataDados(){
    //Dados da venda
    var venda = ajax.responseXML.documentElement.getElementsByTagName("venda");
    var camposNotaVenda = document.getElementsByClassName("nota_venda");
    var camposDataVenda = document.getElementsByClassName("data_venda");
    
    //dados do cliente
    var cliente = ajax.responseXML.documentElement.getElementsByTagName("cliente");
    var camposCliente = document.getElementsByClassName("cliente");
    var camposTelefone = document.getElementsByClassName("telefone");
    var camposCelular = document.getElementsByClassName("celular");
    var endCliente = cliente[0].getElementsByTagName("endereco_cliente")[0].firstChild.nodeValue;
    var refCliente = cliente[0].getElementsByTagName("ref_cliente")[0].firstChild.nodeValue;
    
    //Campo da entrega
    var campoEntrega = document.getElementById("produtosEntrega");
    //Campo da montagem
    var campoMontagem = document.getElementById("produtosMontagem");
    
    var temEntrega = ajax.responseXML.documentElement.getElementsByTagName("tem_entregas")[0].firstChild.nodeValue;
    var temMontagem = ajax.responseXML.documentElement.getElementsByTagName("tem_montagens")[0].firstChild.nodeValue;
    var texto = "";
    
    if(temMontagem=="n" && temEntrega=="n"){
        window.location = "redirecionar.php";
    }
    
    /*                                                          *
     * PREENCHE OS DADOS DO CLIENTE (NOME, TELEFONE E CELULAR)  *
     *                                                          *
     */     
    for(var i=0; i<camposCliente.length; i++){
        texto = "<div class='col-xs-2'>Cliente:</div>";
        texto += "<div class='col-xs-10 underlined'>" + cliente[0].getElementsByTagName("nome")[0].firstChild.nodeValue; + "</div>";
        texto += "</div>";
        camposCliente[i].innerHTML = texto;
        if(cliente[0].getElementsByTagName("telefone")[0].firstChild.nodeValue!==""){
            camposTelefone[i].innerHTML = cliente[0].getElementsByTagName("telefone")[0].firstChild.nodeValue;
        } else {
            camposTelefone[i].innerHTML = "S/N";
        }
        var celular = cliente[0].getElementsByTagName("celular1")[0].firstChild.nodeValue;
        if(celular=="S/N"){
            celular = cliente[0].getElementsByTagName("celular2")[0].firstChild.nodeValue;
        }
        camposCelular[i].innerHTML = celular;
        
        camposNotaVenda[i].innerHTML = venda[0].getElementsByTagName("nota_venda")[0].firstChild.nodeValue;
        camposDataVenda[i].innerHTML = venda[0].getElementsByTagName("data")[0].firstChild.nodeValue;
    }
    
    if(temEntrega=="s"){
        //Preenche os campos relacionados ao cliente.
        
        var entrega = ajax.responseXML.documentElement.getElementsByTagName("entrega");
        texto = "";
        
        if(entrega.length==5){
            document.getElementById("quebra_pagina").innerHTML = "<div class='quebraPagina'></div>";
        }
        
        for (var i=0; i<entrega.length; i++){
        var data = entrega[i].getElementsByTagName('data')[0].firstChild.nodeValue;
        texto += "<div class='row' style='margin-top: 6px'>";
            texto += "<div class='col-xs-1'>Produto:</div>";
            texto += "  <div class='col-xs-7 underlined small'>" + entrega[i].getElementsByTagName('qtde')[0].firstChild.nodeValue + " " + entrega[i].getElementsByTagName('modelo')[0].firstChild.nodeValue + "</div>";
            texto += "  <div class='col-xs-2 underlined small'>DATA: " + data + "</div>";
            texto += "  <div class='col-xs-2 underlined small'><div class='col-xs-1'>Conferido<div class='quadrado' style='margin-left: 25pxs'></div></div></div>";
            texto += "</div>";
            var endAtual = entrega[i].getElementsByTagName('endereco')[0].firstChild.nodeValue;
            if(i==entrega.length-1){
                var proxEnd = "";
            } else {
                var proxEnd = entrega[i+1].getElementsByTagName('endereco')[0].firstChild.nodeValue;
            }
            if(endAtual!==proxEnd || proxEnd==""){
                texto += "<div class='row' style='margin-top: 6px'>";
                    texto += "<div class='col-xs-2'>Endereço:</div>";
                    texto += "<div class='col-xs-10 underlined'>" + entrega[i].getElementsByTagName('endereco')[0].firstChild.nodeValue + "</div>";
                texto += "</div>";
                texto += "<div class='row' style='margin-top: 6px'>";
                    texto += "<div class='col-xs-2'>Pto. Referência:</div>";
                    texto += "<div class='col-xs-10 underlined'>" + entrega[i].getElementsByTagName('referencia')[0].firstChild.nodeValue + "</div>";
                texto += "</div>";
            }
        texto += "</div>";
        }
        
        campoEntrega.innerHTML = texto;
    } else {
        //Recebe os dados da entrega (se n�o houver, limpa o campo);
        document.getElementById("entrega").innerHTML = "<br/><br/>";
    }
    
    if(temMontagem=="s"){
        texto = "";
        var montagem = ajax.responseXML.documentElement.getElementsByTagName("montagem");
        var enderecoMontagem = document.getElementById("end_montagem");
        var referenciaMontagem = document.getElementById("ref_montagem");
        
        if(montagem.length==5){
            document.getElementById("quebra_pagina").innerHTML = "<div class='quebraPagina'></div>";
        }
        
        for(var i=0; i<montagem.length; i++){
            
        var data = montagem[i].getElementsByTagName('data')[0].firstChild.nodeValue;
            texto += "<div class='row' style='margin-top: 6px'>";
            texto += "<div class='col-xs-1'>Produto:</div>";
            texto += "<div class='col-xs-7 underlined small'>" + montagem[i].getElementsByTagName("qtde")[0].firstChild.nodeValue + " " + montagem[i].getElementsByTagName("modelo")[0].firstChild.nodeValue + "</div>";
            texto += "<div class='col-xs-2 underlined small' >DATA: " + data + "</div>";
            texto += "  <div class='col-xs-2 underlined small'><div class='col-xs-1'>Conferido<div class='quadrado' style='margin-left: 25pxs'></div></div></div>";
            texto += "</div>";
        }        
        campoMontagem.innerHTML = texto;
        
        enderecoMontagem.innerHTML = endCliente;
        referenciaMontagem.innerHTML = refCliente;
        
    } else {
        //Recebe os dados da montagem (se n�o houver, limpa o campo);
        document.getElementById("montagem").innerHTML = "";
    }
}