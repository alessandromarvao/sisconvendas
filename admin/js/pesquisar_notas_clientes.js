function obterClientes(){
    doc = document.getElementById('nome').value;
    params = '&nome=' + doc;
    acao =  "obterVendas";
    requisicaoHttp('../php/pesquisarNotaCliente.php', "acao=" + acao + params);
}

function trataDados() {
    var div = document.getElementById("tb");
    xml = ajax.responseXML.documentElement.getElementsByTagName("cliente");
    texto = '<table class="table table-hover table-condensed">';
    texto += '<thead>';
    texto += '<tr>';
    texto += '<th>Nome</th>';
    texto += '<th>CPF</th>';
    texto += '<th>Nota de Venda</th>';
    texto += '<th>Data</th>';
    texto += '</tr>';
    texto += '</thead>';
    texto += '<tbody>';
    for(var i=0; i<xml.length; i++){
        id = xml[i].getElementsByTagName("notaCodificada")[0].firstChild.nodeValue;
        texto += "<tr onclick=\"window.location = '../php/gerarNotaDeVenda.php?id=" + id + "'\">\n";
        aux = xml[i].getElementsByTagName("nome");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("cpf")[0].firstChild.nodeValue;
        texto += "<td>" + aux + "</td>";
        aux = xml[i].getElementsByTagName("nota");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("data");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        texto += "</tr>\n";
    }
    texto += '</tbody>';
    div.innerHTML = texto;
}