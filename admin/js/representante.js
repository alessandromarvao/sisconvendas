function operacoes(operacao){ //utilizada na página cadastrar_representante.php
    acao = operacao;
    campoID = document.getElementById("codigo");
    idRepresentante = document.getElementById("id");
    nome = document.getElementById("nome");
    campoEmpresa = document.getElementById("campoEmpresa"); //DIV que contém as informações da empresa (nome e id). a ID que diz o código da empresa: empresa

    cel1 = document.getElementById("cel1");
    cel2 = document.getElementById("cel2");
    btn = document.getElementById("botao");
    
    if(acao=="obter"){
        requisicaoHttp("../php/operacoesRepresentante.php", "acao=" + acao);
    }else if(acao=="obterUnidade"){ //Ao carregar a página cadastrar_representante.php, obtém informações do representante, caso seja citado.
        obterUnidade();
    } else if(acao=="obterPorNome"){ //Retorna todas as informações do representante caso o nome já exista no Sistema.
        obterPorNome();
    } else if(acao=="obterPorFornecedor"){ //Retorna todas as informações do representante caso o nome já exista no Sistema.
        obterPorFornecedor();
    } else if(acao=="salvar"){ //Salva ou altera as informações do representante desejado.
        salvar();
    }
}

function obterPorNome(){
    params = "acao=" + acao + "&nome=" + nome.value;
    requisicaoHttp("../php/operacoesRepresentante.php", params);
}

function obterPorFornecedor(){
    fornecedor = document.getElementById("fornecedor").value;
    params = "acao=" + acao + "&empresa=" +fornecedor;
    requisicaoHttp("../php/operacoesRepresentante.php", params);
}

//Retorna as informações do representante desejado para realizar alterações ou excluí-lo.
function obterUnidade(){
    id = campoID.value;
    if(id>0){
        params = "acao=" + acao + "&idRepresentante=" + id;
        requisicaoHttp("../php/operacoesRepresentante.php", params);
    } else {
        params = "acao=" + acao;
        requisicaoHttp("../php/operacoesRepresentante.php", params);
    }
}

function salvar(){
        empresa = document.getElementById("empresa").value;
        params = "acao=" + acao + "&nome=" + nome.value + "&empresa=" + empresa + "&celular1=" + cel1.value + "&celular2=" + cel2.value;
        requisicaoHttp("../php/operacoesRepresentante.php", params);
}

function excluir(){
    acao="excluir";
    id = document.getElementById("id").value;
    params = "acao=" + acao + "&idRepresentante=" + id;
    requisicaoHttp("../php/operacoesRepresentante.php", params);
}

function trataDados(){
    if(acao=="obterUnidade"){           /* Resposta do chamado ao carregar a página cadastrar_representante.php */
        //Obtem a resposta do servidor se é para preencher todos os campos ou somente o campo do fornecedor
        retorno = ajax.responseXML.documentElement.getElementsByTagName("retorno");
        resposta = retorno[0].firstChild.nodeValue;
        
        if(resposta=="fornecedor"){     /* Não há nenhum representante citado */
            xml  = ajax.responseXML.documentElement.getElementsByTagName("fornecedor");
            texto = "<select id='empresa' class='form-control'>\n";
            for (var i=0; i<xml.length; i++){
                aux1 = xml[i].getElementsByTagName("id_empresa");
                aux2 = xml[i].getElementsByTagName("empresa");
                texto += "<option value=" + aux1[0].firstChild.nodeValue + ">" + aux2[0].firstChild.nodeValue + "</option>";
            }
            texto += "</select>\n";
            campoEmpresa.innerHTML = texto;
            
            btn.innerHTML = "<input type='reset' class='btn btn-lg btn-block btn-default' value='Limpar' />";
        } else if(resposta=="representante"){       /* Há ao menos um representate selecionado */
            xml  = ajax.responseXML.documentElement.getElementsByTagName("representante");
            aux = xml[0].getElementsByTagName("nome");
            nome.value = aux[0].firstChild.nodeValue;
            aux = xml[0].getElementsByTagName("id_representante");
            idRepresentante.value = aux[0].firstChild.nodeValue;
            aux = xml[0].getElementsByTagName("id_empresa");
            texto = "<input type='text' class='form-control hidden' id='empresa' value='" + aux[0].firstChild.nodeValue+ "' readonly>\n";
            aux = xml[0].getElementsByTagName("empresa");
            texto += "<input type='text' class='form-control' value='" + aux[0].firstChild.nodeValue+ "' readonly>\n";
            campoEmpresa.innerHTML = texto;
            aux = xml[0].getElementsByTagName("celular1");
            cel1.value = aux[0].firstChild.nodeValue;
            aux = xml[0].getElementsByTagName("celular2");
            cel2.value = aux[0].firstChild.nodeValue;
            btn.innerHTML = "<input type='button' class='btn btn-lg btn-block btn-default' value='Excluir' onclick='excluir()' />";
        }
    } else if(acao=="salvar"){          /* Resposta do chamado ao clicar em SALVAR na página cadastrar_representante */
        resposta = ajax.responseText;
        if(resposta == "ok"){
            alert("Cadastro de representante realizado com sucesso. \nClique em OK para retornar à página principal.");
            window.location = "index.php";
        } else if(resposta == "ok1"){
            alert("Alteração realizada com sucesso. \nClique em OK para retornar à página principal.");
            window.location = "index.php";
        } else {
            alert(resposta);
        }
    } else if(acao=="obter" || acao=="obterPorNome" || acao=="obterPorFornecedor"){           /* Resposta do chamado ao carregar ou consultar nome na página consultar_representante.php */
        tabela = document.getElementById("tb");
        
        xml = ajax.responseXML.documentElement.getElementsByTagName("representante");
        texto = '<table class="table table-hover table-condensed">';
        texto += '<thead>';
        texto += '<tr>';
        texto += '<th>Nome</th>';
        texto += '<th>Fornecedor</th>';
        texto += '<th>Celular</th>';
        texto += '<th>Celular</th>';
        texto += '</tr>';
        texto += '</thead>';
        texto += '<tbody>';
        for(var i=0; i<xml.length; i++){
            id = xml[i].getElementsByTagName("id")[0].firstChild.nodeValue;
            texto += "<tr onclick=\"window.location='cadastrar_representante.php?id=" + id + "'\">\n";
            aux = xml[i].getElementsByTagName("nome");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("empresa");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("celular1");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            aux = xml[i].getElementsByTagName("celular2");
            texto += "<td>" + aux[0].firstChild.nodeValue + "</td>";
            texto += "</tr>\n";
        }
        texto += '</tbody>';
        
        tabela.innerHTML = texto;
    } else if(acao=="excluir"){             /* Deleta no Banco de Dados o representante selecionado */
        resposta = ajax.responseText;
        
        if(resposta=="ok"){
            alert("Representante deletado nos registros.");
            window.location = "index.php";
        } else {
            alert(resposta);
        }
    }
}