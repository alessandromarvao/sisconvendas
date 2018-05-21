// ----------------- Inicia requisição com envio de dados --------------------------//
function obterPorNome(){
    var usuario = document.getElementById('nome').value;
    if(usuario=="") {
        limparCampos();
    } else {
        params = '&empresa=' + usuario;
        acao =  "obter";
        requisicaoHttp('../php/buscaFabricante.php', "acao=" + acao + params);
    }
}

var salvarXML = function(){
    acao="salvarXML";
    var file = document.getElementById("file").files[0];
    if(file){
        var fd = new FormData();
        fd.append("xml", file);
        var texto = "<br />";
        texto += "<img alt='carregando' src='../img/loading.gif' />";
        document.getElementById("loading").innerHTML = texto;

        requisicaoHttpFiles("../php/cadastrar_fornecedor_XML.php", fd);
    } else {
        alert("Voc� deve fazer o upload de um arquivo XML primeiro.");
    }
}

function limparCampos(){
    document.getElementById("id").value="";
    document.getElementById("tel").value="";
    document.getElementById("cel").value="";
}

function obterPorID(){
    acao="obterPorID";
    var link = window.location.href.split(".php");
    if(link[1]){
        link = link[1]
        var id = link.split("?id=")[1];
        var params = "&id=" + id;
        
        requisicaoHttp('../php/buscaFabricante.php', "acao=" + acao + params);
    }
}

function salvar(){
    acao = 'salvar';
    var empresa = document.getElementById("nome");
    if(empresa.value!==""){
        var nomeEmpresa = empresa.value;
        var contato = document.getElementById("contato").value;
        var telefone = document.getElementById("tel").value;
        var celular = document.getElementById("cel").value;
        var representante = document.getElementById("representante").value;
        var cel1 = document.getElementById("cel1_representante").value;
        var cel2 = document.getElementById("cel2_representante").value;
        var id = 0;
        if(document.getElementById("id").value!==""){
            id = document.getElementById("id").value;
        }
        var params = "acao=salvar&id=" + id + "&nome=" + nomeEmpresa + "&contato=" + contato + "&tel=" + telefone + "&cel=" + celular + "&rep=" + representante + "&cel1_rep=" + cel1 + "&cel2_rep=" + cel2;

        requisicaoHttp('../php/cadastrar_fornecedor.php', params);
    } else {
        alert("Por favor, preencher o nome da Empresa.");
        empresa.focus(true);
    }
}

function trataDados() {
    var nome = document.getElementById("nome");
    var contato = document.getElementById("contato");
    var telefone = document.getElementById("tel");
    var id = document.getElementById("id");
    var celular = document.getElementById("cel");
    var representante = document.getElementById("representante");
    var celular1Rep = document.getElementById("cel1_representante");
    var celular2Rep = document.getElementById("cel2_representante");
    if(acao == 'obter'){
        var div = document.getElementById("botao");
        var xml = ajax.responseXML.documentElement.getElementsByTagName("fornecedor");
        var nm = xml[0].getElementsByTagName("nome");
        var tel = xml[0].getElementsByTagName("telefone");
        var cod = xml[0].getElementsByTagName("id");
        var cel = xml[0].getElementsByTagName("celular");
        var cont = xml[0].getElementsByTagName("contato");
        var rep = xml[0].getElementsByTagName("representante");
        var cel1rep = xml[0].getElementsByTagName("celular1_representante");
        var cel2rep = xml[0].getElementsByTagName("celular2_representante");
        
        nome.value = nm[0].firstChild.nodeValue;
        contato.value = cont[0].firstChild.nodeValue;
        telefone.value = tel[0].firstChild.nodeValue;
        id.value = cod[0].firstChild.nodeValue;
        celular.value = cel[0].firstChild.nodeValue;
        representante.value = rep[0].firstChild.nodeValue;
        celular1Rep.value = cel1rep[0].firstChild.nodeValue;
        celular2Rep.value = cel2rep[0].firstChild.nodeValue;
        
        if(nm!==""){
            div.innerHTML = "<input type='button' class='btn btn-lg btn-block btn-danger' value='Apagar' title='Apaga os registros do fornecedor' onclick='excluir()'/>";
        }
        
    } else if(acao=="obterPorID"){
        xml = ajax.responseXML.documentElement;    
        
        nome.value = xml.getElementsByTagName("nome")[0].firstChild.nodeValue;
        contato.value = xml.getElementsByTagName("contato")[0].firstChild.nodeValue;
        telefone.value = xml.getElementsByTagName("telefone")[0].firstChild.nodeValue;
        id.value = xml.getElementsByTagName("id")[0].firstChild.nodeValue;
        celular.value = xml.getElementsByTagName("celular")[0].firstChild.nodeValue;
        representante.value = xml.getElementsByTagName("representante")[0].firstChild.nodeValue;
        celular1Rep.value = xml.getElementsByTagName("celular1_representante")[0].firstChild.nodeValue;
        celular2Rep.value = xml.getElementsByTagName("celular1_representante")[0].firstChild.nodeValue;
    } else if(acao == 'salvar'){
        alert(ajax.responseText);
        window.location = "consultar_fornecedor.php";
    } else if(acao == "excluir"){
        if(ajax.responseText=="ok"){
            alert("Fornecedor deletado com sucesso.");
            window.location = "index.php";
        } else {
            alert(ajax.responseText);
        }
    } else if(acao=="salvarXML"){
        document.getElementById("loading").innerHTML = "";
        alert(ajax.responseText);
        window.location = "index.php";
    }
}