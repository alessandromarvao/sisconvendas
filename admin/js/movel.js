// ----------------- Inicia requisição com envio de dados --------------------------//
function enviaDados(act){
    doc = document.getElementById("modelo").value;
    params = '&modelo=' + doc;
    acao =  act;
    requisicaoHttp('../php/pesquisarMovel.php', "acao=" + acao + params);
}

var obterTodos = function() {
    var div = document.getElementById("tb");
    xml = ajax.responseXML.documentElement.getElementsByTagName("movel");
    texto = '<table class="table table-hover table-condensed">';
    texto += '<thead>';
    texto += '<tr>';
    texto += '<th>Modelo</th>';
    texto += '<th>Fabricante</th>';
    texto += '<th>Qtde no Estoque</th>';
    texto += '<th>Valor R$</th>';
    texto += '<th>Tipo</th>';
    texto += '</tr>';
    texto += '</thead>';
    texto += '<tbody>';
    for(var i=0; i<xml.length; i++){
        qtd = xml[i].getElementsByTagName("qtde")[0].firstChild.nodeValue;
        id = xml[i].getElementsByTagName("codigoB64")[0].firstChild.nodeValue;
        if(qtd<=2){
            texto += "<tr class='bg-warning text-danger' onclick=\"window.location = 'alterar_movel.php?id=" + id + "'\">\n";
        } else {
            texto += "<tr onclick=\"window.location = 'alterar_movel.php?id=" + id + "'\">\n";
        }
        aux = xml[i].getElementsByTagName("modelo");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("fornecedor");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("qtde");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("valor_venda");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("tipo");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        texto += "</tr>\n";
    }
    texto += '</tbody>';
    div.innerHTML = texto;
};

var obterEstoqueBaixo = function(){
    var div = document.getElementById("tb");
    xml = ajax.responseXML.documentElement.getElementsByTagName("movel");
    texto = '<table class="table table-hover table-condensed">';
    texto += '<thead>';
    texto += '<tr>';
    texto += '<th>Modelo</th>';
    texto += '<th>Fabricante</th>';
    texto += '<th>Qtde. no Estoque</th>';
    texto += '<th>Tipo</th>';
    texto += '<th>ID</th>';
    texto += '</tr>';
    texto += '</thead>';
    texto += '<tbody>';
    for(var i=0; i<xml.length; i++){
        id = xml[i].getElementsByTagName("codigoB64")[0].firstChild.nodeValue;
        texto += "<tr onclick=\"window.location = 'comprar_movel.php?id=" + id + "'\">\n";
        aux = xml[i].getElementsByTagName("modelo");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("fornecedor");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("qtde");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("tipo");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("codigo");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        texto += "</tr>\n";
    }
    texto += '</tbody>';
    div.innerHTML = texto;
};

function trataDados() {
    
    if(acao == 'obter'){
        obterTodos();        
    } else if(acao == 'obterLimite'){ // Obtem os móveis com baixo estoque
        obterEstoqueBaixo();    
    } else if(acao=="salvar"){
        xml = ajax.responseText;
        alert(xml);
    }
}