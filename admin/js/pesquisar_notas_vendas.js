function consultaCampo(){
    var dia = document.getElementById("dia");
    var periodo = document.getElementById("periodo");
    var vendedor = document.getElementById("periodo_vend");
    var clientes = document.getElementById("rd_clientes");
    var nota = document.getElementById("nota");
    var todos = document.getElementById("todos");
    var campoDia = document.getElementById("campo_dia");
    var campoDatas = document.getElementById("campo_datas");
    var campoVendedor = document.getElementById("campo_datas_vendedor");
    var campoClientes = document.getElementById("campo_pesquisar_cliente");
    var campoNota = document.getElementById("campo_nota");
    var campoTotal = document.getElementById("campo_total");
    var texto = "";
    
    if(dia.checked==true){
        texto = "<br />";
        texto += "<div class='col-md-6'>";
        texto += "<input type='date' class='form-control' id='dt_dia' placeholder='AAAA-MM-DD' />";
        texto += "</div>";
        texto += "<div class='col-md-4'>";
        texto += "<button class='btn btn-md btn-block btn-success' onclick='pesquisarPorDia()'>";
            texto += "<span class='glyphicon glyphicon-search' ></span> Pesquisar";
        texto += "</button>";
        texto += "<br />";
        texto += "</div>";  
        campoDia.innerHTML = texto;
        campoDatas.innerHTML = "";
        campoNota.innerHTML = "";
        campoTotal.innerHTML = "";
        vendedor.innerHTML = "";
        campoClientes.innerHTML = "";
    } else if(periodo.checked==true){
        texto = "<br />";
        texto += "<div class='row'>";
            texto += "<div class='col-md-6'>";
                texto += "<input type='date' class='form-control' id='dt_data1' placeholder='AAAA-MM-DD' />";
            texto += "</div>";
            texto += "<div class='col-md-6'>";
                texto += "<input type='date' class='form-control' id='dt_data2' placeholder='AAAA-MM-DD' />";
            texto += "</div>";
            texto += "<br />";
            texto += "<br />";
            texto += "<div class='col-md-6'>";
                texto += "<button class='btn btn-md btn-block btn-success' onclick='pesquisarPorPeriodo()'>";
                    texto += "<span class='glyphicon glyphicon-search' ></span> Pesquisar";
                texto += "</button>";
            texto += "</div>";
        texto += "</div>";
        campoDatas.innerHTML = texto;
        campoDia.innerHTML = "";
        campoNota.innerHTML = "";
        campoTotal.innerHTML = "";
        campoVendedor.innerHTML = "";
        campoClientes.innerHTML = "";
    } else if(vendedor.checked==true){
        texto = "<br />";
        texto += "<div class='row'>";
            texto += "<div class='col-md-6'>";
                texto += "<input type='date' class='form-control' id='v_data1' placeholder='AAAA-MM-DD' />";
            texto += "</div>";
            texto += "<div class='col-md-6'>";
                texto += "<input type='date' class='form-control' id='v_data2' placeholder='AAAA-MM-DD' />";
            texto += "</div>";
            texto += "<br />";
            texto += "<br />";
            texto += "<div class='col-md-6'>";
                texto += "<button class='btn btn-md btn-block btn-success' onclick='pesquisarVendedorPorPeriodo()'>";
                    texto += "<span class='glyphicon glyphicon-search' ></span> Pesquisar";
                texto += "</button>";
            texto += "</div>";
        texto += "</div>";
        campoDatas.innerHTML = "";
        campoDia.innerHTML = "";
        campoNota.innerHTML = "";
        campoTotal.innerHTML = "";
        campoClientes.innerHTML = "";
        campoVendedor.innerHTML = texto;
        
    } else if(nota.checked==true){
        campoDatas.innerHTML = "";
        campoDia.innerHTML = "";
        campoTotal.innerHTML = "";
        campoVendedor.innerHTML = "";
        campoClientes.innerHTML = "";
        texto = "<br/>";
        texto += "<div class='row'>";
            texto += "<div class='col-md-6'>";
            texto += "<input type='text' class='form-control' id='txtNota' placeholder='Digite aqui o Nº da Nota de Venda' />";
            texto += "</div>";
            texto += "<br/>";
            texto += "<br/>";
            texto += "<div class='col-md-6'>";
                texto += "<button class='btn btn-md btn-block btn-success' onclick='pesquisarPorNota()'>";
                    texto += "<span class='glyphicon glyphicon-search' ></span> Pesquisar";
                texto += "</button>";
            texto += "</div>";
        texto += "</div>";
        campoNota.innerHTML = texto;
    } else if(todos.checked==true){
        campoDatas.innerHTML = "";
        campoDia.innerHTML = "";
        campoNota.innerHTML = "";
        campoVendedor.innerHTML = "";
        campoClientes.innerHTML = "";
        texto = "<br />";
        texto += "<div class='row'>";
            texto += "<div class='col-md-6'>";
                texto += "<button class='btn btn-md btn-block btn-success' onclick='pesquisarTodos()'>";
                    texto += "<span class='glyphicon glyphicon-search' ></span> Pesquisar";
                texto += "</button>";
            texto += "</div>";
        texto += "</div>";
        campoTotal.innerHTML = texto;
    } else if(clientes.checked==true){
        campoDatas.innerHTML = "";
        campoDia.innerHTML = "";
        campoNota.innerHTML = "";
        campoVendedor.innerHTML = "";
        campoTotal.innerHTML = "";
        texto = "<br />";
        texto += "<div class='row'>";
            texto += "<div class='col-md-6'>";
                texto += "<button class='btn btn-md btn-block btn-success' onclick='pesquisarClientes()'>";
                    texto += "<span class='glyphicon glyphicon-search' ></span> Pesquisar";
                texto += "</button>";
            texto += "</div>";
        texto += "</div>";
        campoClientes.innerHTML = texto;
        
    }
}

function pesquisarClientes(){
    window.location = "pesquisar_nota_venda_clientes.php";
}

function pesquisarPorDia(){
    var dia = document.getElementById("dt_dia");
    if(dia.value==""){
        alert("Você não preencheu o campo!");
        dia.focus();
    } else {
        acao = "obterPorDia";
        var params = "&data1=" + dia.value;
        requisicaoHttp("../php/operacoesNota.php", "acao=" + acao + params);
    }
}

function pesquisarPorPeriodo(){
    var data1 = document.getElementById("dt_data1");
    var data2 = document.getElementById("dt_data2");
    if(data1.value!=="" && data2.value!==""){
        acao = "obterPorPeriodo";
        var params = "&data1=" + data1.value + "&data2=" + data2.value;
        requisicaoHttp("../php/operacoesNota.php", "acao=" + acao + params);
    } else if(data1.value==""){
        alert("Você não preencheu todos os campos");
        data1.focus();
    } else if(data2.value==""){
        alert("Você não preencheu todos os campos");
        data2.focus();        
    }
}

/**
 * Calcula os valores vendidos por cada vendedor por um período de tempo.
 * 
 * @returns void
 */
var pesquisarVendedorPorPeriodo = function(){
    var data1 = document.getElementById("v_data1");
    var data2 = document.getElementById("v_data2");
    
    if(data1.value!=="" && data2.value!==""){
        acao = "listarVendasPorPeriodo";
        var params = "acao=" + acao + "&data1=" + data1.value + "&data2=" + data2.value;
        requisicaoHttp("../php/operacoesNota.php", params);
    } else if(data1.value==""){
        alert("Você não preencheu todos os campos");
        data1.focus();        
    } else if(data2.value==""){
        alert("Você não preencheu todos os campos");
        data2.focus();        
    }
}

function pesquisarPorNota(){
    var nota = document.getElementById("txtNota");
    if(nota.value!==""){
        acao = "obterPorNota";
        var params = "&nota=" + nota.value;
        requisicaoHttp("../php/operacoesNota.php", "acao=" + acao + params);
    } else {
        alert("Você não preencheu o campo");
        nota.focus();
    }
}

function pesquisarTodos(){
    acao = "obterTodos";
    requisicaoHttp("../php/operacoesNota.php", "acao=" + acao);
}

function trataDados(){
    if(acao=="obterPorDia"){
        window.location = "pesquisar_notas_venda.php" + ajax.responseText;
    } else if(acao=="obterPorPeriodo"){
        window.location = "pesquisar_notas_venda.php" + ajax.responseText;
    } else if(acao=="listarVendasPorPeriodo"){
        window.location = "relatorio_vendedor.php" + ajax.responseText;
    } else if(acao=="obterPorNota"){
        window.location = "../php/gerarNotaDeVenda.php" + ajax.responseText;
    } else {
        window.location = "pesquisar_notas_venda.php" + ajax.responseText;
    }
}