function confereCampoVazio(campo){
    cliente = document.getElementById(campo).value;
    
    if(cliente=="___.___.___-__" || cliente==""){
        return true;
    } else {
        return false;
    }
}

// ----------------- Inicia requisição com envio de dados --------------------------//
function enviaDados(act, campo){
    cliente = document.getElementById(campo);
    params = '&cpf=' + cliente.value;
    acao =  act;
    if(acao=='salvar'){
        if(confereCampoVazio(campo)== true){
            alert("Você esqueceu de digitar o CPF do cliente.");
            document.getElementById("cpf").focus();
        } else if(confereCampoVazio("nome")){
            alert("Você esqueceu de digitar o nome do cliente.");
            document.getElementById("nome").focus();
        } else if(confereCampoVazio("bai")){
            alert("Você esqueceu de digitar o bairro que o cliente reside.");
            document.getElementById("bai").focus();
        } else if(confereCampoVazio("end")){
            alert("Você esqueceu de digitar o endereço do cliente.");
            document.getElementById("end").focus();
        } else if(confereCampoVazio("ref")){
            alert("Você esqueceu de digitar o ponto de referência da residência do cliente.");
            document.getElementById("ref").focus();
        } else {
            var cpf = document.getElementById("cpf").value;
            var nome = document.getElementById("nome").value;
            var email = document.getElementById("email").value;
            var dataNascimento = document.getElementById("data_nascimento").value;
            var end = document.getElementById("end").value;
            var bairro = document.getElementById("bai").value;
            var ref = document.getElementById("ref").value;
            var cep = document.getElementById("cep").value;
            var telefone = document.getElementById("tel").value;
            var cel1 = document.getElementById("cel1").value;
            var cel2 = document.getElementById("cel2").value;

            param = 'txtCPF=' + cpf + '&txtNome=' + nome + '&txtEmail=' + email + '&txtDataNascimento=' + dataNascimento + '&txtEnd=' + end + '&txtBairro=' + bairro + '&txtReferencia=' + ref + '&txtCEP=' + cep + '&txtTelefone=' + telefone + '&txtCel1=' + cel1 + '&txtCel2=' + cel2;
            requisicaoHttp("../php/cadastrar_cliente.php", param);
        }
    } else if(acao=='obter' && cliente.value!=="___.___.___-__") {
        requisicaoHttp('../php/buscaCliente.php', "acao=" + acao + params);
    }
}

function trataDados() {
    var cpf = document.getElementById("cpf");
    var nome = document.getElementById("nome");
    var email = document.getElementById("email");
    var dataNascimento = document.getElementById("data_nascimento");
    var end = document.getElementById("end");
    var bairro = document.getElementById("bai");
    var ref = document.getElementById("ref");
    var cep = document.getElementById("cep");
    var telefone = document.getElementById("tel");
    var celular1 = document.getElementById("cel1");
    var celular2 = document.getElementById("cel2");
    
    if(acao == 'obter'){
        xml = ajax.responseXML.documentElement.getElementsByTagName("cliente");
        
        nm = xml[0].getElementsByTagName("nome");
        em = xml[0].getElementsByTagName("email");
        dn = xml[0].getElementsByTagName("dataNascimento");
        cc = xml[0].getElementsByTagName("cpf");
        ed = xml[0].getElementsByTagName("endereco");
        br = xml[0].getElementsByTagName("bairro");
        rf = xml[0].getElementsByTagName("referencia");
        cp = xml[0].getElementsByTagName("cep");
        tel = xml[0].getElementsByTagName("telefone");
        cel1 = xml[0].getElementsByTagName("celular1");
        cel2 = xml[0].getElementsByTagName("celular2");
        
        nome.value = nm[0].firstChild.nodeValue;
        dataNascimento.value = dn[0].firstChild.nodeValue;
        email.value = em[0].firstChild.nodeValue;
        cpf.value = cc[0].firstChild.nodeValue;
        end.value = ed[0].firstChild.nodeValue;
        bairro.value = br[0].firstChild.nodeValue;
        ref.value = rf[0].firstChild.nodeValue;
        cep.value = cp[0].firstChild.nodeValue;
        telefone.value = tel[0].firstChild.nodeValue;
        celular1.value = cel1[0].firstChild.nodeValue;
        celular2.value = cel2[0].firstChild.nodeValue;
    } else if(acao=='salvar'){
        alert(ajax.responseText);
        window.location = "index.php";
    }
}