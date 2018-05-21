function carregarPagina(){
    chkData = document.getElementById("chkData");
    chkEmpresa = document.getElementById("chkEmpresa");
    chkMovel = document.getElementById("chkMovel");
    requisicaoHttp("../php/obterMoveisComprados.php", "acao=todos");
}

function checaCampo(campo){
    campoData = document.getElementById("divDatas");
    campoFornecedor = document.getElementById("divEmpresa");
    campoMovel = document.getElementById("divMovel");
    document.getElementById("divResultado").innerHTML = "";
    if(campo=='data'){
        chk = document.getElementById("chkData");
        document.getElementById("chkEmpresa").checked = false;
        document.getElementById("chkEmpresa").value = 0;
        document.getElementById("chkMovel").checked = false;
        document.getElementById("chkMovel").value = 0;
        campoFornecedor.innerHTML = "";
        campoMovel.innerHTML = "";
        
        confereDados("data");
    } else if(campo=='empresa'){
        chk = document.getElementById("chkEmpresa");
        document.getElementById("chkData").checked = false;
        document.getElementById("chkData").value = 0;
        document.getElementById("chkMovel").checked = false;
        document.getElementById("chkMovel").value = 0;
        campoData.innerHTML = "";
        campoMovel.innerHTML = "";
        
        confereDados("fornecedor");
    } else if(campo=='movel'){
        chk = document.getElementById("chkMovel");
        document.getElementById("chkData").checked=false;
        document.getElementById("chkData").value = 0;
        document.getElementById("chkEmpresa").checked = false;
        document.getElementById("chkEmpresa").value = 0;
        campoFornecedor.innerHTML = "";
        campoData.innerHTML = "";
        
        confereDados("movel");
    }
}

function confereDados(param){
    if(chk.value==0){
        chk.value = 1;
        
        criarCampos(param);
    } else if(chk.value==1){
        chk.value = 0;
        chk.checked = false;
    }
}

function criarCampos(param){
    if(param=="data"){
        texto = "<div class='col-md-4'>\n";
            texto += "<input type='date' class='form-control ' id='txtData1' />\n";
        texto += "</div>\n";
        texto += "<div class='col-md-4'>\n";
            texto += "<input type='date' class='form-control ' id='txtData2' />\n";
        texto += "</div>\n";
        texto += "<div class='col-md-4'>\n";
            texto += "<input type='button' class='btn btn-md btn-block btn-success' value='Pesquisar' onclick='obterPorData()' />\n";
        texto += "</div>\n";
        
        campoData.innerHTML = texto;
    } else if(param=="fornecedor"){
        texto = "<input type='text' class='form-control' id='txtEmpresa' onkeyup='obterPorFornecedor()' placeholder='Digite aqui a razão social do fornecedor' />\n";
        campoFornecedor.innerHTML = texto;
    } else if(param=="movel"){
        texto = "<input type='text' class='form-control' id='txtMovel' onkeyup='obterPorMovel()' placeholder='Digite aqui o modelo do móvel desejado' />\n";
        campoMovel.innerHTML = texto;
    }
}

function obterPorData(){
    var data1 = document.getElementById("txtData1").value;
    var data2 = document.getElementById("txtData2").value;
    var params = "data1=" + data1 + "&data2=" + data2;
    
    requisicaoHttp("../php/obterMoveisComprados.php", params);
}

function obterPorFornecedor(){
    var empresa = document.getElementById("txtEmpresa").value;
    var params = "empresa=" + empresa;
    
    requisicaoHttp("../php/obterMoveisComprados.php", params);
}

function obterPorMovel(){
    var moveis = document.getElementById("txtMovel").value;
    var params = "movel=" + moveis;
    
    requisicaoHttp("../php/obterMoveisComprados.php", params);
}

function trataDados(){
    var campo = document.getElementById("divResultado");
    var resposta = ajax.responseXML.documentElement.getElementsByTagName("compra");
        texto = "<table class='table table-condensed'>";
        texto += "<tr>";
            texto += "<td>Modelo</td>";
            texto += "<td>Data da Compra</td>";
            texto += "<td>Qtde Comprada</td>";
            texto += "<td>Valor (R$)</td>";
            texto += "<td>Fornecedor</td>";
        texto += "</tr>";
    for(var i=0; i<resposta.length; i++){
        var modelo = resposta[i].getElementsByTagName("modelo")[0].firstChild.nodeValue;
        var data = resposta[i].getElementsByTagName("data")[0].firstChild.nodeValue;
        var qtde = resposta[i].getElementsByTagName("qtde")[0].firstChild.nodeValue;
        var valor = resposta[i].getElementsByTagName("valor")[0].firstChild.nodeValue;
        var fornecedor = resposta[i].getElementsByTagName("fornecedor")[0].firstChild.nodeValue;
            texto += "<tr>";
            texto += "<td>" + modelo + "</td>";
            texto += "<td>" + data + "</td>";
            texto += "<td>" + qtde + "</td>";
            texto += "<td>" + valor + "</td>";
            texto += "<td>" + fornecedor + "</td>";
            texto += "</tr>";
    }
    texto += "</table>";
    campo.innerHTML = texto;
}