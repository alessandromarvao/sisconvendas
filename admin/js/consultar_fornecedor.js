function obter(param){
    acao = "pesquisar";
    var params="";
    
    if(param=="empresa"){
        nome = document.getElementById("fornecedor").value;
        params = '&empresa=' + nome;
    } else if(param=="representante"){
        nome = document.getElementById("representante").value;
        params = '&representante=' + nome;
    } else if(param==''){
        nome = document.getElementById("fornecedor").value;
        params = '&empresa=' + nome;
    } else if(param=='todos'){
        params = "Todos";
    }
    
    requisicaoHttp('../php/buscaFabricante.php', "acao=" + acao + params);
}

function trataDados() {
    var div = document.getElementById("tb");
    
    if(acao == 'pesquisar'){
        xml = ajax.responseXML.documentElement.getElementsByTagName("fornecedor");
        texto = '<table class="table table-hover table-condensed">';
        texto += '<thead>';
        texto += '<tr>';
        texto += '<th>Empresa</th>';
        texto += '<th>Telefone</th>';
        texto += '<th>Celular</th>';
        texto += '<th>Representante</th>';
        texto += '<th>Celular</th>';
        texto += '<th>Celular</th>';
        texto += '</tr>';
        texto += '</thead>';
        texto += '<tbody>';
        for(var i=0; i<xml.length; i++){
            id = xml[i].getElementsByTagName("idB64")[0].firstChild.nodeValue;
            texto += "<tr onclick=\"window.location='cadastrar_fornecedor.php?id=" + id + "'\">\n";
            aux = xml[i].getElementsByTagName("nome");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("telefone");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("celular");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("representante");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("cel1_representante");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("cel2_representante");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            texto += "</tr>\n";
        }
        texto += '</tbody>';
        div.innerHTML = texto;
    }
}