function teste(acao, campo){
    enviaDados(acao, campo);
}

// ----------------- Inicia requisição com envio de dados --------------------------//
function enviaDados(act, campo){
    doc = document.getElementById(campo).value;
    params = '&nome=' + doc;
    acao =  act;
    requisicaoHttp('../php/pesquisarFuncionario.php', "acao=" + acao + params);
}

function trataDados() {
    var div = document.getElementById("tb");
    
    if(acao == 'obter'){
        xml = ajax.responseXML.documentElement.getElementsByTagName("usuario");
        texto = '<table class="table table-hover table-condensed">';
        texto += '<thead>';
        texto += '<tr>';
        texto += '<th>Usuario</th>';
        texto += '<th>Nome</th>';
        texto += '<th>Função</th>';
        texto += '<th>Situação</th>';
        texto += '<th>Senha bloqueada</th>';
        texto += '</tr>';
        texto += '</thead>';
        texto += '<tbody>';
        for(var i=0; i<xml.length; i++){
            id = xml[i].getElementsByTagName("loginCodificado")[0].firstChild.nodeValue;
            texto += "<tr onclick=\"window.location = 'alterar_funcionario.php?id=" + id + "'\">\n";
            aux = xml[i].getElementsByTagName("login");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("nome");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("funcao");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("situacao");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("senha_bloqueada");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            texto += "</tr>\n";
        }
        texto += '</tbody>';
        div.innerHTML = texto;
    }
}