function obterClientes(){
    doc = document.getElementById('nome').value;
    params = '&nome=' + doc;
    acao =  "obter";
    requisicaoHttp('../php/pesquisarCliente.php', "acao=" + acao + params);
}

function obterAniversariantesDoMes(){
    var acao="obterAniversariantes";
    requisicaoHttp('../php/pesquisarCliente.php', "acao=" + acao);
}

function obterAniversariantesDoDia(){
    var acao="obterAniversariantesDoDia";
    requisicaoHttp('../php/pesquisarCliente.php', "acao=" + acao);
}

function trataDados() {
    var div = document.getElementById("tb");
    xml = ajax.responseXML.documentElement.getElementsByTagName("cliente");
    texto = '<table class="table table-hover table-condensed">';
    texto += '<thead>';
    texto += '<tr>';
    texto += '<th>Nome</th>';
    texto += '<th>Endereco</th>';
    texto += '<th>E-mail</th>';
    texto += '<th>Nascimento</th>';
    texto += '<th>Telefone Fixo</th>';
    texto += '<th>Telefone Celular</th>';
    texto += '<th>Telefone Celular</th>';
    texto += '</tr>';
    texto += '</thead>';
    texto += '<tbody>';
    for(var i=0; i<xml.length; i++){
        id = xml[i].getElementsByTagName("cpfCodificado")[0].firstChild.nodeValue;
        texto += "<tr onclick=\"window.location = 'alterar_cliente.php?id=" + id + "'\">\n";
        aux = xml[i].getElementsByTagName("nome");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("endereco")[0].firstChild.nodeValue + ", " + xml[i].getElementsByTagName("bairro")[0].firstChild.nodeValue;
        texto += "<td>" + aux + "</td>";
        aux = xml[i].getElementsByTagName("email");
        texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
        aux = xml[i].getElementsByTagName("data_nascimento");
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