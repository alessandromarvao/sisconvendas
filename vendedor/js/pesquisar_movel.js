function teste(acao, campo){
    enviaDados(acao, campo);
}

// ----------------- Inicia requisição com envio de dados --------------------------//
function enviaDados(act, campo){
    var doc = document.getElementById(campo).value;
    params = '&modelo=' + doc;
    acao =  act;
    requisicaoHttp('../php/pesquisarMovel.php', "acao=" + acao + params);
}

function obterTodos(){
    acao = "obterMostruario";
    requisicaoHttp('../php/pesquisarMovel.php', "acao=" + acao);
}

function trataDados() {
    var div = document.getElementById("tb");
    
    xml = ajax.responseXML.documentElement.getElementsByTagName("movel");
        texto = '<table class="table table-hover table-condensed">';
        texto += '<thead>';
        texto += '<tr>';
        texto += '<th>Modelo</th>';
        texto += '<th>Fabricante</th>';
        texto += '<th>Tipo</th>';
        texto += '<th>Qtde. no Estoque</th>';
        texto += '<th>Valor (R$)</th>';
        texto += '</tr>';
        texto += '</thead>';
        texto += '<tbody>';
        for(var i=0; i<xml.length; i++){
            id = xml[i].getElementsByTagName("codigoB64")[0].firstChild.nodeValue;
            texto += "<tr onclick=\"window.location = 'vender_movel.php?id=" + id + "'\">\n";
            aux = xml[i].getElementsByTagName("modelo");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("fornecedor");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("tipo");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("qtde");
            texto += "<td class='text-center'>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("valor_venda");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            texto += "</tr>\n";
        }
        texto += '</tbody>';
        div.innerHTML = texto;
        
        nome.value = nm[0].firstChild.nodeValue;
        telefone.value = tel[0].firstChild.nodeValue;
        id.value = cod[0].firstChild.nodeValue;
    
//    if(acao == 'obter'){
//        xml = ajax.responseXML.documentElement.getElementsByTagName("movel");
//        texto = '<table class="table table-hover table-condensed">';
//        texto += '<thead>';
//        texto += '<tr>';
//        texto += '<th>Modelo</th>';
//        texto += '<th>Fabricante</th>';
//        texto += '<th>Tipo</th>';
//        texto += '<th>Qtde. no Estoque</th>';
//        texto += '<th>Valor (R$)</th>';
//        texto += '</tr>';
//        texto += '</thead>';
//        texto += '<tbody>';
//        for(var i=0; i<xml.length; i++){
//            id = xml[i].getElementsByTagName("codigoB64")[0].firstChild.nodeValue;
//            texto += "<tr onclick=\"window.location = 'vender_movel.php?id=" + id + "'\">\n";
//            aux = xml[i].getElementsByTagName("modelo");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("fornecedor");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("tipo");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("qtde");
//            texto += "<td class='text-center'>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("valor_venda");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            texto += "</tr>\n";
//        }
//        texto += '</tbody>';
//        div.innerHTML = texto;
//        
//        nome.value = nm[0].firstChild.nodeValue;
//        telefone.value = tel[0].firstChild.nodeValue;
//        id.value = cod[0].firstChild.nodeValue;
//    } else if(acao == 'obterEstoque'){
//        xml = ajax.responseXML.documentElement.getElementsByTagName("movel");
//        texto = '<table class="table table-hover table-condensed">';
//        texto += '<thead>';
//        texto += '<tr>';
//        texto += '<th>Modelo</th>';
//        texto += '<th>Fabricante</th>';
//        texto += '<th>Tipo</th>';
//        texto += '<th>Qtde. no Estoque</th>';
//        texto += '<th>Valor (R$)</th>';
//        texto += '</tr>';
//        texto += '</thead>';
//        texto += '<tbody>';
//        for(var i=0; i<xml.length; i++){
//            id = xml[i].getElementsByTagName("codigoB64")[0].firstChild.nodeValue;
//            texto += "<tr onclick=\"window.location = 'vender_movel.php?id=" + id + "'\">\n";
//            aux = xml[i].getElementsByTagName("modelo");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("fornecedor");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("tipo");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("qtde");
//            texto += "<td class='text-center'>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("valor_venda");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            texto += "</tr>\n";
//        }
//        texto += '</tbody>';
//        div.innerHTML = texto;
//        
//        nome.value = nm[0].firstChild.nodeValue;
//        telefone.value = tel[0].firstChild.nodeValue;
//        id.value = cod[0].firstChild.nodeValue;
//    } else if(acao=="obterMostruario"){
//        xml = ajax.responseXML.documentElement.getElementsByTagName("movel");
//        texto = '<table class="table table-hover table-condensed">';
//        texto += '<thead>';
//        texto += '<tr>';
//        texto += '<th>Modelo</th>';
//        texto += '<th>Fabricante</th>';
//        texto += '<th>Tipo</th>';
//        texto += '<th>Qtde. no Estoque</th>';
//        texto += '<th>Valor (R$)</th>';
//        texto += '</tr>';
//        texto += '</thead>';
//        texto += '<tbody>';
//        for(var i=0; i<xml.length; i++){
//            id = xml[i].getElementsByTagName("codigoB64")[0].firstChild.nodeValue;
//            texto += "<tr onclick=\"window.location = 'vender_movel.php?id=" + id + "'\">\n";
//            aux = xml[i].getElementsByTagName("modelo");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("fornecedor");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("tipo");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("qtde");
//            texto += "<td class='text-center'>" + aux[0].firstChild.nodeValue + "</td>";
//            aux = xml[i].getElementsByTagName("valor_venda");
//            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
//            texto += "</tr>\n";
//        }
//        texto += '</tbody>';
//        div.innerHTML = texto;
//        
//        nome.value = nm[0].firstChild.nodeValue;
//        telefone.value = tel[0].firstChild.nodeValue;
//        id.value = cod[0].firstChild.nodeValue;
//    }
}