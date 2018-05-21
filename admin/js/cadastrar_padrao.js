var acao="";

function salvar(){
    acao = "salvar";
    var senha = document.getElementById("padrao").value;
    requisicaoHttp("../php/cadastrar_padrao.php", "acao=" + acao + "&txtPwd=" + senha);
}

var carregarPadrao = function(){
    acao = "carregar";
    requisicaoHttp("../php/cadastrar_padrao.php", "acao=" + acao);
}

function trataDados(){
    if(acao=="carregar"){
        var campo = document.getElementById("padrao");
        campo.value = ajax.responseText;
    } else if(acao=="salvar"){
        alert(ajax.responseText);
        window.location = "index.php";
    }
}


