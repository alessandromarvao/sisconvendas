function _(id){
    return document.getElementById(id);
}

var criar_barra_progresso = function(){
    var file = _("file").files[0];
    if(file){
        var fd = new FormData();
        fd.append("xml", file);
        var texto = "<br />";
        texto += "<img alt='carregando' src='../img/loading.gif' />";
        _("loading").innerHTML = texto;
        
        requisicaoHttpFiles("../php/cadastrar_moveis.php", fd);
    } else {
        alert("Você deve fazer o upload de um arquivo XML primeiro.");
    }
}

var salvar = function(){
    criar_barra_progresso();
}

function trataDados(){
    _("loading").innerHTML = "";
    alert(ajax.responseText);
    window.location = "index.php";
}