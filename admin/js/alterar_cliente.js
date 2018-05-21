var carregar = function (){
    acao = "obter";
    var cpf = document.getElementById("txtCPF").value;
    var param = "acao=" + acao + "&cpf=" + cpf;
    requisicaoHttp('../php/buscaCliente.php', param);
}

var salvar = function (){
    acao="salvar";
    var cpf = document.getElementById("txtCPF").value;
    var nome = document.getElementById("txtNome").value;
    var data = document.getElementById("txtDataNascimento").value;
    var email = document.getElementById("txtEmail").value;
    var end = document.getElementById("txtEnd").value;
    var bairro = document.getElementById("txtBairro").value;
    var ref = document.getElementById("txtRef").value;
    var cep = document.getElementById("txtCEP").value;
    var tel = document.getElementById("txtTel").value;
    var cel1 = document.getElementById("txtCel1").value;
    var cel2 = document.getElementById("txtCel2").value;
    if(nome!=="" && email!=="" && end!=="" && bairro!=="" && ref!==""){
        var param = "txtCPF=" + cpf + "&txtNome=" + nome + "&txtEmail=" + email + "&txtEnd=" 
                + end + "&txtBairro=" + bairro + "&txtReferencia=" + ref + "&txtCEP=" + cep 
                + "&txtTelefone=" + tel + "&txtCel1=" + cel1 + "&txtCel2=" + cel2 + "&txtDataNascimento=" + data;
        requisicaoHttp("../php/cadastrar_cliente.php", param);
    } else {
        if(nome==""){
            alert("Você esqueceu de preencher o nome do cliente.");
            document.getElementById("txtNome").focus();
        } else if(email==""){
            alert("Você esqueceu de preencher o email do cliente.");
            document.getElementById("txtEmail").focus();
        } else if(end==""){
            alert("Você esqueceu de preencher o endereço do cliente.");
            document.getElementById("txtEnd").focus();
        } else if(bairro==""){
            alert("Você esqueceu de preencher o bairo que o cliente reside.");
            document.getElementById("txtBairro").focus();
        } else if(ref==""){
            alert("Você esqueceu de preencher o ponto de referência do endereço do cliente.");
            document.getElementById("txtRef").focus();
        } else {
            alert("erro aqui");
        }
    }
}

function trataDados(){
    if(acao=="obter"){
        var nome = document.getElementById("txtNome");
        var email = document.getElementById("txtEmail");
        var data = document.getElementById("txtDataNascimento");
        var end = document.getElementById("txtEnd");
        var bairro = document.getElementById("txtBairro");
        var ref = document.getElementById("txtRef");
        var cep = document.getElementById("txtCEP");
        var tel = document.getElementById("txtTel");
        var cel1 = document.getElementById("txtCel1");
        var cel2 = document.getElementById("txtCel2");
        
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("cliente");
        
        nome.value = resposta[0].getElementsByTagName("nome")[0].firstChild.nodeValue;
        email.value = resposta[0].getElementsByTagName("email")[0].firstChild.nodeValue;
        data.value = resposta[0].getElementsByTagName("dataNascimento")[0].firstChild.nodeValue;
        end.value = resposta[0].getElementsByTagName("endereco")[0].firstChild.nodeValue;
        bairro.value = resposta[0].getElementsByTagName("bairro")[0].firstChild.nodeValue;
        ref.value = resposta[0].getElementsByTagName("referencia")[0].firstChild.nodeValue;
        cep.value = resposta[0].getElementsByTagName("cep")[0].firstChild.nodeValue;
        tel.value = resposta[0].getElementsByTagName("telefone")[0].firstChild.nodeValue;
        cel1.value = resposta[0].getElementsByTagName("celular1")[0].firstChild.nodeValue;
        cel2.value = resposta[0].getElementsByTagName("celular2")[0].firstChild.nodeValue;
    } else {
        alert(ajax.responseText);
        window.location = "index.php";
    }
}