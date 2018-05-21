function teste(acao, campo){
    enviaDados(acao, campo);
}

// ----------------- Inicia requisição com envio de dados --------------------------//
function enviaDados(act, campo){
    usuario = document.getElementById(campo).value;
    params = '&usr=' + usuario;
    acao =  act;
    requisicaoHttp('../php/buscaFuncionario.php', "acao=" + acao + params);
}

function salvar(){
    acao = "salvar";
    var login = document.getElementById("login").value;
    var nome = document.getElementById("nome").value;
    var cpf = document.getElementById("cpf").value;
    var funcao = document.getElementById("funcao").value;
    var email = document.getElementById("email").value;
    var dataNascimento = document.getElementById("data_nascimento").value;
    var tel = document.getElementById("tel").value;
    var cel1 = document.getElementById("cel1").value;
    var cel2 = document.getElementById("cel2").value;
    
    if(login!=="" && nome!=="" && cpf!=="" && funcao!==""){
        params = "txtLogin=" + login + "&txtNome=" + nome + "&txtCPF=" + cpf + "&txtFuncao=" + funcao + "&txtEmail=" + email + "&txtNascimento=" + dataNascimento + "&txtTel=" + tel + "&txtCel1=" + cel1 + "&txtCel2=" + cel2;
        requisicaoHttp("../php/cadastrar_usuario.php", params);
    } else if(login!==""){
        alert("Você deve citar o login do usuario!");
    } else if(nome!==""){
        alert("Você deve citar o nome do usuario!");
    } else if(cpf!==""){
        alert("Você deve citar o CPF do usuario!");
    }
}

function trataDados() {
    var nome = document.getElementById("nome");
    var cpf = document.getElementById("cpf");
    var email = document.getElementById("email");
    var nascimento = document.getElementById("data_nascimento");
    var telefone = document.getElementById("tel");
    var celular1 = document.getElementById("cel1");
    var celular2 = document.getElementById("cel2");
    if(acao == 'obter'){
        xml = ajax.responseXML.documentElement.getElementsByTagName("usuario");
        nm = xml[0].getElementsByTagName("nome");
        cp = xml[0].getElementsByTagName("cpf");
        nasc = xml[0].getElementsByTagName("nascimento");
        em = xml[0].getElementsByTagName("email");
        tel = xml[0].getElementsByTagName("telefone");
        cel1 = xml[0].getElementsByTagName("celular1");
        cel2 = xml[0].getElementsByTagName("celular2");
        
        nome.value = nm[0].firstChild.nodeValue;
        cpf.value = cp[0].firstChild.nodeValue;
        email.value = em[0].firstChild.nodeValue;
        nascimento.value = nasc[0].firstChild.nodeValue;
        telefone.value = tel[0].firstChild.nodeValue;
        celular1.value = cel1[0].firstChild.nodeValue;
        celular2.value = cel2[0].firstChild.nodeValue;
    } else if(acao == 'salvar'){
        xml = ajax.responseText;
        
        var confirmacao = confirm(xml + "Clique em OK para voltar à página principal e CANCELAR para realizar outro cadastro.");
        if(confirmacao==true){
            window.location = "index.php";
        } else {
            login="";
            nome="";
            cpf="";
            tel="";
            cel1="";
            cel2="";
        }
    } else {
        nome.value = "";
        cpf.value = "";
        funcao.value = "";
        telefone.value = "";
        celular.value = "";
    }
}