var imprimir = function(){
    window.print();
    window.location = "gerarNotasEntregaEMontagem.php?id=" + nota;
    if(idVendasMoveis!==""){
    } else {
        window.location = "redirecionar.php";
    }
}

function cancelar(){
    window.location = "redirecionar.php";
}

function carregarNotaDeVenda(){
    acao = "carregarVenda";
    idVenda = document.getElementById("id_venda").value;
    var param = "acao=" + acao + "&idVenda=" + idVenda;
    requisicaoHttp("emitirNotaVenda.php", param);
}

function preencherCampoCliente(){
    campoVendedor = document.getElementById("vendedor");
    campoNotaVenda = document.getElementById("nota_venda");
    campoData = document.getElementById("data");
    campoHora = document.getElementById("hora");
    campoCliente = document.getElementById("nome");
    campoEnd = document.getElementById("endereco");
    campoTel = document.getElementById("tel");
    campoCel1 = document.getElementById("cel1");
    campoCel2 = document.getElementById("cel2");
    campoDesconto = document.getElementById("desconto");
    campoTotal = document.getElementById("total");
    
    campoVendedor.innerHTML = vendedor;    
    campoNotaVenda.innerHTML = idVenda;    
    campoData.innerHTML = data;
    campoHora.innerHTML = hora;
    campoCliente.innerHTML = cliente;
    campoEnd.innerHTML = end;
    campoTel.innerHTML = tel;
    campoCel1.innerHTML = cel1;
    campoCel2.innerHTML = cel2;
    campoDesconto.innerHTML = desconto;
    campoTotal.innerHTML = total;
    
    acao = "carregarMoveisComprados";
    
    var param = "acao=" + acao + "&idVenda=" + idVenda;
    requisicaoHttp("emitirNotaVenda.php", param);
}

function gerarFormasPagamento(){
    acao = "gerarFormasPagamento";
    
    var param = "acao=" + acao + "&idVenda=" + idVenda;
    requisicaoHttp("emitirNotaVenda.php", param);
}

function trataDados(){
    if(acao=="carregarVenda"){
        ehVazio = ajax.responseXML.documentElement.getElementsByTagName("vazio")[0].firstChild.nodeValue;
        if(ehVazio=="n"){
            var resposta = ajax.responseXML.documentElement.getElementsByTagName("nota_venda");
            vendedor = resposta[0].getElementsByTagName("vendedor")[0].firstChild.nodeValue;
            data = resposta[0].getElementsByTagName("data")[0].firstChild.nodeValue;
            hora = resposta[0].getElementsByTagName("hora")[0].firstChild.nodeValue;
            cliente = resposta[0].getElementsByTagName("nome_cliente")[0].firstChild.nodeValue;
            end = resposta[0].getElementsByTagName("endereco")[0].firstChild.nodeValue;
            tel = resposta[0].getElementsByTagName("telefone")[0].firstChild.nodeValue;
            cel1 = resposta[0].getElementsByTagName("celular1")[0].firstChild.nodeValue;
            cel2 = resposta[0].getElementsByTagName("celular2")[0].firstChild.nodeValue;
            desconto = resposta[0].getElementsByTagName("desconto")[0].firstChild.nodeValue;
            total = resposta[0].getElementsByTagName("valor_total")[0].firstChild.nodeValue;
            preencherCampoCliente();
        } else {
            window.location = "redirecionar.php";
        }
    } else if(acao=="carregarMoveisComprados"){
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("movel");
        var respostaTotalBruto = ajax.responseXML.documentElement.getElementsByTagName("total_bruto")[0].firstChild.nodeValue;
        document.getElementById('total_bruto').innerHTML = "<td>" + respostaTotalBruto + "</td>";
        var camposMoveis = document.getElementById("moveis");
        texto = "<table class='table table-condensed'>\n";
            texto += "<tr >\n";
                texto += "<td class='small'>Descrição:</td>\n";
                texto += "<td class='small'>Qtde:</td>\n";
                texto += "<td class='small'>Valor Unit. (R$):</td>\n";
                texto += "<td class='small'>Total (R$):</td>\n";
                texto += "<td class='small'>Entrega:</td>\n";
                texto += "<td class='small'>Montagem:</td>\n";
            texto += "</tr>\n";
        for(var i=0; i<resposta.length; i++){
            texto += "<tr class='small'>\n";
            modelo = resposta[i].getElementsByTagName("modelo")[0].firstChild.nodeValue;
            marca = resposta[i].getElementsByTagName("fornecedor")[0].firstChild.nodeValue;
            texto += "<td class=''>" + modelo + " " + marca + "</td>\n";
            qtde = resposta[i].getElementsByTagName("qtde")[0].firstChild.nodeValue;
            texto += "<td class='small text-center'>" + qtde + "</td>\n";
            valorUnitario = resposta[i].getElementsByTagName("valor_unitario")[0].firstChild.nodeValue;
            texto += "<td class='small'>" + valorUnitario + "</td>\n";
            valorTotal = resposta[i].getElementsByTagName("valor_total")[0].firstChild.nodeValue;
            texto += "<td class='small'>" + valorTotal + "</td>\n";
            entrega = resposta[i].getElementsByTagName("entrega")[0].firstChild.nodeValue;
            montagem = resposta[i].getElementsByTagName("montagem")[0].firstChild.nodeValue;
            nota = resposta[i].getElementsByTagName("id_venda")[0].firstChild.nodeValue;
            if(entrega==0){
                texto += "<td class='small'>NÃO</td>";
            } else {
                texto += "<td class='small'>" + entrega + "</td>";
            }
            if(montagem==0){
                texto += "<td class='small'>NÃO</td>";
            } else {
                texto += "<td class='small'>" + montagem + "</td>";
            }
            texto += "</tr>\n";
        }
        texto += "</table>\n";
        camposMoveis.innerHTML = texto;
        gerarFormasPagamento();
    } else if(acao=="gerarFormasPagamento"){
        var formas = document.getElementById("formas_pagamento");
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("pagamento");
        
        texto = "<table class='table table-condensed'>\n";
            texto += "<tr class=''>\n";
                texto += "<td>Forma de pagamento selecionada:</td>\n";
                texto += "<td>Parcelas:</td>\n";
                texto += "<td>Valor da Parcela (R$):</td>\n";
                texto += "<td>Total (R$):</td>\n";
            texto += "</tr>\n";
            for(var i=0; i<resposta.length; i++){
            var respostaParcela = ajax.responseXML.documentElement.getElementsByTagName("parcelado")[i].firstChild.nodeValue;
                texto += "<tr class='small'>\n";
                texto += "<td class='small'>" + resposta[i].getElementsByTagName("forma_pagamento")[0].firstChild.nodeValue + "</td>";
                if(respostaParcela=="s"){
                    texto += "<td class='small'>" + resposta[i].getElementsByTagName("qtd_parcelas")[0].firstChild.nodeValue + "</td>";
                    texto += "<td class='small'>" + resposta[i].getElementsByTagName("valor_parcelas")[0].firstChild.nodeValue + "</td>";
                } else {
                    texto += "<td class='small'>1</td>";
                    texto += "<td class='small'>" + resposta[i].getElementsByTagName("valor_pago")[0].firstChild.nodeValue + "</td>";
                }
                texto += "<td class='small'>" + resposta[i].getElementsByTagName("valor_pago")[0].firstChild.nodeValue + "</td>";
                texto += "</tr>\n";
            }
        texto += "</table>\n";
        formas.innerHTML = texto;
        
        var via1 = document.getElementById("via1");
        var via2 = document.getElementById("via2");
        
        via2.innerHTML = via1.innerHTML;
    }
}