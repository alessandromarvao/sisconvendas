var id_movel = 0;
var id_fornecedor = 0;
var modelo = "";
var tipo = "";
var imagem = "";
var estoque = 0;
var valor = 0.0;

/**
 * Carrega as informações do móvel desejado.
 * 
 * @returns void
 */
var carregar = function(){
    var link = window.location.href;
    acao = "obterUnidade";
    var id = link.split("?id=")[1];
    
    requisicaoHttp("../php/obterMovel.php", "acao=" + acao + "&id=" + id);
};

/**
 * Cria a select contendo todos os Fornecedores do Sistema.
 * 
 * @returns void
 */
var criaFornecedores = function(){
    acao = "obterFornecedores";
    requisicaoHttp("../php/buscaFabricante.php", "acao=obter");
};

/**
 * Cria select contendo todos os tipos de móveis do Sistema.
 * 
 * @returns void
 */
var criaTipos = function(){
    acao = "carregarTipos";
    requisicaoHttp("../php/obterMovel.php", "acao=" + acao);
};

/**
 * Preenche os campos da página.
 * 
 * @returns void
 */
var preencheCampos = function(){
    document.getElementById("cod_movel").value = "";
    criaSelectFornecedor(resposta);
};

var preencheCampos = function(){
    document.getElementById("modelo").value = modelo;
    document.getElementById("estoque").value = estoque;
    document.getElementById("valor").value = valor;
    document.getElementById("cod_movel").value = id_movel;
    if(imagem !== " ") {
        document.getElementById("img").src = imagem;
    }
    
};

function trataDados() {
    if(acao=="obterUnidade"){
        var resposta = ajax.responseXML.documentElement;
        
        id_movel = resposta.getElementsByTagName("id_movel")[0].firstChild.nodeValue;
        id_fornecedor = resposta.getElementsByTagName("id_fornecedor")[0].firstChild.nodeValue;
        tipo = resposta.getElementsByTagName("tipo")[0].firstChild.nodeValue;
        imagem = resposta.getElementsByTagName("img")[0].firstChild.nodeValue;
        modelo = resposta.getElementsByTagName("modelo")[0].firstChild.nodeValue;
        estoque = resposta.getElementsByTagName("estoque")[0].firstChild.nodeValue;
        valor = resposta.getElementsByTagName("valor")[0].firstChild.nodeValue;
        
        document.getElementById("titulo").innerHTML = "<h2>ALTERAR " + modelo + "</h2>";
        
        criaTipos();
    } else if(acao=="carregarTipos"){
        var select = document.getElementById("tipos");
        
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("tipo");
        
        var tipos = "";
        for(var i=0; i<resposta.length; i++) {
            //Armazena na variável o tipo selecionado no enlace.
            tipos = resposta[i].firstChild.nodeValue;            
            //cria o campo OPTION
            var options = document.createElement("option");
            //cria o atributo VALUE para o OPTION
            options.setAttribute("value", tipos);
            //cria o texto a ser adicionado no OPTION
            var campos = document.createTextNode(tipos);
            //adiciona o texto no OPTION desejado
            options.appendChild(campos);
            //adiciona o campo OPTION no SELECT desejado
            select.appendChild(options);
            
            if(resposta[i].firstChild.nodeValue==tipo){
                select.selectedIndex=i;
            }
        }
        criaFornecedores();
    } else if(acao=="obterFornecedores") {
        var select = document.getElementById("fornecedores");
        
        var resposta = ajax.responseXML.documentElement.getElementsByTagName("fornecedor");
        var tipos = "";
        for(var i=0; i<resposta.length; i++) {
            //Armazena na variável o tipo selecionado no enlace.
            //cria o campo OPTION
            var options = document.createElement("option");
            //cria o atributo VALUE para o OPTION
            options.setAttribute("value", resposta[i].getElementsByTagName("id")[0].firstChild.nodeValue);
            //cria o texto a ser adicionado no OPTION
            var campos = document.createTextNode(resposta[i].getElementsByTagName("nome")[0].firstChild.nodeValue);
            //adiciona o texto no OPTION desejado
            options.appendChild(campos);
            //adiciona o campo OPTION no SELECT desejado
            select.appendChild(options);
            
            if(resposta[i].getElementsByTagName("id")[0].firstChild.nodeValue==id_fornecedor){
                select.selectedIndex=i;
            }
            
            preencheCampos();
        }
    }
}