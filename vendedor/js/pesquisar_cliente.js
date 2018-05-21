function teste(acao, campo){
    enviaDados(acao, campo);
}

// ----------------- Inicia requisi��o com envio de dados --------------------------//
function enviaDados(act, campo){
    doc = document.getElementById(campo).value;
    params = '&nome=' + doc;
    acao =  act;
    requisicaoHttp('../php/pesquisarCliente.php', "acao=" + acao + params);
}

function trataDados() {
    var div = document.getElementById("tb");
    
    if(acao == 'obter'){
        xml = ajax.responseXML.documentElement.getElementsByTagName("cliente");
        texto = '<table class="table table-hover table-condensed">';
        texto += '<thead>';
        texto += '<tr>';
        texto += '<th>Nome</th>';
        texto += '<th>Endereço</th>';
        texto += '<th>Bairro</th>';
        texto += '<th>Telefone Fixo</th>';
        texto += '<th>Telefone Celular</th>';
        texto += '<th>Telefone Celular</th>';
        texto += '</tr>';
        texto += '</thead>';
        texto += '<tbody>';
        for(var i=0; i<xml.length; i++){
            id = xml[i].getElementsByTagName("cpfCodificado")[0].firstChild.nodeValue;
            texto += "<tr onclick=\"window.location = 'pesquisar_movel.php?id=" + id + "'\">\n";
            aux = xml[i].getElementsByTagName("nome");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("endereco");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("bairro");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("telefone");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("celular1");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("celular2");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            texto += "</tr>\n";
        }
        texto += '</tbody>';
        div.innerHTML = texto;
    }
}