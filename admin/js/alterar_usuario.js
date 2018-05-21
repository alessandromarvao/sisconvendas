acao="";
var carregar = function(){
    acao = "obter";
    var login = document.getElementById("login").value;
    var param = "acao=" + acao + "&usr=" + login;
    requisicaoHttp("../php/buscaFuncionario.php", param);
}

function salvar(){
    acao = "salvar";
    var opcao = document.getElementById("opcao").value;
    var login = document.getElementById("login").value;
    var nome = document.getElementById("nome").value;
    var params = "txtLogin=" + login + "&txtNome=" + nome + "&opcao=" + opcao;
    
    requisicaoHttp("../php/alterar_acesso_usuario.php", params);
}

function trataDados(){
    if(acao=="obter"){
        var nome = document.getElementById("nome");
        var funcao = document.getElementById("cargo");
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("usuario");
        
        nome.value = resposta[0].getElementsByTagName("nome")[0].firstChild.nodeValue;
        funcao.value = resposta[0].getElementsByTagName("funcao")[0].firstChild.nodeValue;
    } else {
        alert(ajax.responseText);
        window.location = "index.php";
    }
}


