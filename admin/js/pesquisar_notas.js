var imprimir = function (){
    window.print();
}

function carregar(){
    var params;
    acao = document.getElementById("acao").value;
    if(acao=="obterPorDia"){
        var data = document.getElementById("data1").value;
        params = "&data1=" + data;
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao + params);
    } else if(acao=="obterPorPeriodo"){
        var data1 = document.getElementById("data1").value;
        var data2 = document.getElementById("data2").value;
        params = "&data1=" + data1 + "&data2=" + data2;
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao + params);
    } else if(acao=="listarVendasPorPeriodo") {
        var data1 = document.getElementById("data1").value;
        var data2 = document.getElementById("data2").value;
        params = "&data1=" + data1 + "&data2=" + data2;
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao + params);
    } else {
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao);
    }
}

function abrir(param){
    window.location = "../php/gerarNotaDeVenda.php?id=" + param;
}

function carregarRecebimentos(){
    if(acao=="obterPorDia"){
        acao = "obterRecebimentosPorDia";
        var data1 = document.getElementById("data1").value;
        var params = "&data1=" + data1;
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao + params);
    } else if(acao=="obterPorPeriodo"){
        acao = "obterRecebimentosPorPeriodo";
        var data1 = document.getElementById("data1").value;
        var data2 = document.getElementById("data2").value;
        var params = "&data1=" + data1 + "&data2=" + data2;
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao + params);
    } else if(acao=="obterTodos"){
        acao = "obterTodosRecebimentos";
        requisicaoHttp("../php/obterVendas.php", "acao=" + acao);
    }
}

function trataDados(){
    if(acao=="obterPorDia" || acao=="obterPorPeriodo" || acao=="obterTodos"){
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("venda");
        var campo = document.getElementById("pesquisa");
        var texto = "";

        document.getElementById("periodo").innerHTML = ajax.responseXML.getElementsByTagName("periodo")[0].firstChild.nodeValue;

        for(var i=0; i<resposta.length; i++){
            var a = i+1;
            var nota = resposta[i].getElementsByTagName("nota")[0].firstChild.nodeValue;
            var valor = resposta[i].getElementsByTagName("valor")[0].firstChild.nodeValue;
            var notaCodificada = resposta[i].getElementsByTagName("nota_codificada")[0].firstChild.nodeValue;
            if(i%3==0){
                if(i!==0){
                    texto += "</div>";
                    texto += "<div class='row'>";
                }
                if(i==0){
                texto += "<div class='row'>";
                }
                texto += "<div class=\'col-xs-1 underlined text-center sp-horizontal\' onclick=\'abrir(\"" + notaCodificada + "\")\' >";
                    texto += nota;
                texto += "</div>";
                texto += "<div class=\'col-xs-1 mg-horizontal underlined text-center sp-horizontal\' onclick=\'abrir(\"" + notaCodificada + "\")\' >";
                    texto += valor;
                texto += "</div>";                
            } else {
                texto += "<div class='col-xs-1 mg-horizontal underlined text-center sp-horizontal' onclick=\'abrir(\"" + notaCodificada + "\")\' >";
                    texto += nota;
                texto += "</div>";
                texto += "<div class=\'col-xs-1 mg-horizontal underlined text-center sp-horizontal\' onclick=\'abrir(\"" + notaCodificada + "\")\' >";
                    texto += valor;
                texto += "</div>";
            }
        campo.innerHTML = texto;
        }
        
        carregarRecebimentos();
    } else if(acao=="obterRecebimentosPorDia" || acao=="obterRecebimentosPorPeriodo" || acao=="obterTodosRecebimentos"){
        resposta = ajax.responseXML.documentElement.getElementsByTagName("pagamento");
        campo = document.getElementById("pagamentos");
        
        texto = "";
        for (var i=0; i<resposta.length; i++){
            texto += "<div class='row small'>";
                texto += "<div class='col-xs-6 col-xs-offset-1 underlined'>";
                    texto += resposta[i].getElementsByTagName("forma")[0].firstChild.nodeValue;
                texto += "</div>";
                texto += "<div class='col-xs-3 col-xs-offset-1 text-center underlined'>";
                    texto += "R$ " + resposta[i].getElementsByTagName("valor_pago")[0].firstChild.nodeValue;
                texto += "</div>";
            texto += "</div>";
        }
        campo.innerHTML = texto;
    } else if (acao=="listarVendasPorPeriodo"){
        var periodo = ajax.responseXML.documentElement.getElementsByTagName("periodo")[0].firstChild.nodeValue;
        document.getElementById("periodo").innerHTML = periodo;
        resposta = ajax.responseXML.documentElement.getElementsByTagName("vendedor");
        var texto = "<table class='table table-condensed col-xs-12'>";
        texto += "<thead>";
        texto += "<tr>";
        texto += "<td>Nome do Vendedor</td>";
        texto += "<td>CPF</td>";
        texto += "<td>Vendas</td>";
        texto += "<td>Total (R$)</td>";
        texto += "</tr>";
        texto += "</thead>";
        texto += "<tbody class='small'>";
        for (var i=0; i<resposta.length; i++){
            texto += "<tr>";
                texto += "<td>" + resposta[i].getElementsByTagName("nome")[0].firstChild.nodeValue + "</td>";
                texto += "<td>" + resposta[i].getElementsByTagName("cpf")[0].firstChild.nodeValue + "</td>";
                texto += "<td>" + resposta[i].getElementsByTagName("vendas")[0].firstChild.nodeValue + "</td>";
                texto += "<td>" + resposta[i].getElementsByTagName("valor_total")[0].firstChild.nodeValue + "</td>";
            texto += "</tr>";
        }
        texto += "</tbody>";
        texto += "</table>";
        document.getElementById("resultado").innerHTML = texto;
    }
}
