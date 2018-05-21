//Cria o select das formas de pagamento único
function gerarFormasPagamentoPrincipal(){
    acao = "gerarFormasPagamentoPrincipal";
    campoFormasPagamento = document.getElementById("campo_formas_pagamento");
    valor = document.getElementById("valor_absoluto");
    requisicaoHttp("../php/operacoesPagamento.php", "acao=" + acao);
}

//Cria o select das formas de pagamento da entrada
function gerarFormasPagamentoEntrada(){
    acao = "gerarFormasPagamentoEntrada";
    campoFormasPagamento = document.getElementById("campo_forma_pagamento_entrada");
    valor = document.getElementById("");
    requisicaoHttp("../php/operacoesPagamento.php", "acao=" + acao);
}

//Cria o select das formas de pagamento da pendência
function gerarFormasPagamentoPendente(){
    acao = "gerarFormasPagamentoPendente";
    campoFormasPagamento = document.getElementById("campo_forma_pagamento_pendencia");
    valor = document.getElementById("");
    requisicaoHttp("../php/operacoesPagamento.php", "acao=" + acao);
}

//Confere as formas de pagamento Principal e gera as outras formas de pagamento se o usuário assim selecionar.
function confereParcelaPrincipal(){
    selectPagamento = document.getElementById("selectPagamentoPrincipal").value;
    
    //seleciona os campos de entrada e pendência a serem apagados
    parcelasPrincipal = document.getElementById("campo_parcelado"); //Parcelas do pagamento único
    valorEntrada = document.getElementById("campo_valor_entrada"); //Valor do primeiro pagamento
    formaPagamentoEntrada = document.getElementById("campo_forma_pagamento_entrada"); //Forma do primeiro pagamento
    parcelasEntrada = document.getElementById("campo_parcelas_entrada"); //parcelas do primeiro pagamento
    formaPagamentoPendencia = document.getElementById("campo_forma_pagamento_pendencia"); //Forma do segundo pagamento
    parcelasPendencia = document.getElementById("campo_parcelas_pendencia"); //Parcelas do segundo pagamento
    valorPendente = document.getElementById("campo_pendente"); //Valor do segundo pagamento
    
    //para pagamento parcelado
    if(selectPagamento==3 || selectPagamento==4 || selectPagamento==5 || selectPagamento==6 || selectPagamento==7 || selectPagamento==9 || selectPagamento==10){
        acao= "gerarParcelasPrincipal"; //Para uso apenas no JS.
        valor = document.getElementById("valor_absoluto").value;
        var juros = "n";
        if(selectPagamento==7){
            juros = "s";
        }
        valorEntrada.innerHTML = "";
        formaPagamentoEntrada.innerHTML = "";
        parcelasEntrada.innerHTML = "";
        formaPagamentoPendencia.innerHTML = "";
        parcelasPendencia.innerHTML = "";
        valorPendente.innerHTML = "";
        
        requisicaoHttp("../php/operacoesPagamento.php", "acao=gerarParcelas&valor=" + valor + "&juros=" + juros);
    } else if(selectPagamento==15){ //Para realizar o pagamento de duas formas
        campoEntrada = document.getElementById("campo_valor_entrada"); //Cria o campo Entrada
        texto = "<label>Valor</label>\n";
        texto += "<input type='text' class='form-control' id='valor_entrada' onkeyup='calcularPendencia()'/> ";
        campoEntrada.innerHTML = texto;
        parcelasPrincipal.innerHTML = "";
        gerarFormasPagamentoEntrada();
    } else {
        parcelasPrincipal.innerHTML = "";
        valorEntrada.innerHTML = "";
        formaPagamentoEntrada.innerHTML = "";
        parcelasEntrada.innerHTML = "";
        formaPagamentoPendencia.innerHTML = "";
        parcelasPendencia.innerHTML = "";
        valorPendente.innerHTML = "";
    }
}

//Confere as formas de pagamento Principal e gera as outras formas de pagamento se o usuário assim selecionar.
function confereParcelaEntrada(){
    selectPagamento = document.getElementById("selectPagamentoEntrada").value;
    
    //seleciona os campos de entrada e pendência a serem apagados
    formaPagamentoEntrada = document.getElementById("campo_forma_pagamento_entrada"); //Forma do primeiro pagamento
    parcelasEntrada = document.getElementById("campo_parcelas_entrada"); //parcelas do primeiro pagamento
    var valorEntrada = document.getElementById("valor_entrada");
    
    if(valorEntrada.value!==""){
        //para pagamento parcelado
        if(selectPagamento==3 || selectPagamento==4 || selectPagamento==5 || selectPagamento==6 || selectPagamento==7 || selectPagamento==9 || selectPagamento==10){
            acao= "gerarParcelasEntrada"; //Para uso apenas no JS.
            valor = document.getElementById("valor_entrada").value;

            requisicaoHttp("../php/operacoesPagamento.php", "acao=gerarParcelas&valor=" + valor);
        } else {
            parcelasEntrada.innerHTML = "";
        }
    } else {
        alert("Por favor, informe o valor do pagamento.");
        valorEntrada.focus();
    }
    
}

//Confere as formas de pagamento Principal e gera as outras formas de pagamento se o usuário assim selecionar.
function confereParcelaPendente(){
    selectPagamento = document.getElementById("selectPagamentoPendente").value;
    
    //seleciona os campos de entrada e pendência a serem apagados
    formaPagamentoPendencia = document.getElementById("campo_forma_pagamento_pendencia"); //Forma do segundo pagamento
    parcelasPendencia = document.getElementById("campo_parcelas_pendencia"); //Parcelas do segundo pagamento
    valorPendente = document.getElementById("campo_pendente"); //Valor do segundo pagamento
    
    //para pagamento parcelado
    if(selectPagamento==3 || selectPagamento==4 || selectPagamento==5 || selectPagamento==6 || selectPagamento==7 || selectPagamento==9 || selectPagamento==10){
        acao= "gerarParcelasPendencia"; //Para uso apenas no JS.
        valor = document.getElementById("valor_pendente").value;
        requisicaoHttp("../php/operacoesPagamento.php", "acao=gerarParcelas&valor=" + valor);
    } else {
        parcelasPendencia.innerHTML = "";
    }
}

//Cria o input para o valor pendente.
function gerarValorPendente(){
    acao="gerarValorPendente";
    campoPendente = document.getElementById("campo_pendente");
    var valorPrincipal = document.getElementById("valor_absoluto").value;
    
    params = "acao=gerarValor" + "&valor=" + valorPrincipal;
    
    requisicaoHttp("../php/operacoesPagamento.php", params);
}

//Recebe o valor da entrada e calcula o valor pendente
function calcularPendencia(){
    valorEntrada = document.getElementById("valor_entrada").value;
    valorPrincipal = document.getElementById("valor_absoluto").value;
    acao = "gerarValorPendente";
    
    params = "acao=gerarValor&valor=" + valorPrincipal + "&valorEntrada=" + valorEntrada;
    
    requisicaoHttp("../php/operacoesPagamento.php", params);
}

function salvar(){ //ação: salvar; pagamento: à vista/parcelado; parcelas 1a10; valor: valor do pagamento
    acao = "salvar";
    var formaPagamento = document.getElementById("selectPagamentoPrincipal").value;
    //recebe o valor total do pagamento
    var valorTotal = document.getElementById("valor_absoluto").value;
    //recebe o número da nota de venda
    var notaVenda = document.getElementById("nota_venda").value;
    
    //compra parcelada
    if(formaPagamento==3 || formaPagamento==4 || formaPagamento==5 || formaPagamento==6 || formaPagamento==7 || formaPagamento==9 || formaPagamento==10){
        //recebe quantidade de parcelas.
        var parcelas = document.getElementById("selectParcelas").value;
        
        var params = "acao=salvar&pagamento=parcelado&forma=" + formaPagamento + "&parcelas=" + parcelas + "&valor=" + valorTotal + "&notaVenda=" + notaVenda;
        requisicaoHttp("../php/operacoesPagamento.php", params);
    } else if(formaPagamento==15) { //Pagamento com duas modalidades
        salvarPagamentoEntrada();
    } else { //Pagamentos à vista        
        var params = "acao=salvar&pagamento=avista&forma=" + formaPagamento + "&valor=" + valorTotal + "&notaVenda=" + notaVenda;
        requisicaoHttp("../php/operacoesPagamento.php", params);
    }
}

function salvarPagamentoEntrada(){
    acao="salvarEntrada";
    var formaPagamento = document.getElementById("selectPagamentoEntrada").value;
    var valorEntrada = document.getElementById("valor_entrada").value;
    //recebe o número da nota de venda
    var notaVenda = document.getElementById("nota_venda").value;
    
    if(formaPagamento==3 || formaPagamento==4 || formaPagamento==5 || formaPagamento==6 || formaPagamento==7 || formaPagamento==9 || formaPagamento==10){
        //recebe quantidade de parcelas.
        var parcelas = document.getElementById("selectParcelasEntrada").value;
        
        var params = "acao=salvar&pagamento=parcelado&forma=" + formaPagamento + "&parcelas=" + parcelas + "&valor=" + valorEntrada + "&notaVenda=" + notaVenda;
        requisicaoHttp("../php/operacoesPagamento.php", params);
    } else { //Pagamentos à vista        
        var params = "acao=salvar&pagamento=avista&forma=" + formaPagamento + "&valor=" + valorEntrada + "&notaVenda=" + notaVenda;
        requisicaoHttp("../php/operacoesPagamento.php", params);
    }
}

function salvarPagamentoPendente(){
    acao = "salvarPendencia";
    var formaPagamento = document.getElementById("selectPagamentoPendente").value;
    var valor = document.getElementById("valor_pendente").value;
    //recebe o número da nota de venda
    var notaVenda = document.getElementById("nota_venda").value;
    
    if(formaPagamento==3 || formaPagamento==4 || formaPagamento==5 || formaPagamento==6 || formaPagamento==7 || formaPagamento==9 || formaPagamento==10){
        //recebe quantidade de parcelas.
        var parcelas = document.getElementById("selectParcelasPendencia").value;
        
        var params = "acao=salvar&pagamento=parcelado&forma=" + formaPagamento + "&parcelas=" + parcelas + "&valor=" + valor + "&notaVenda=" + notaVenda;
        requisicaoHttp("../php/operacoesPagamento.php", params);
    } else { //Pagamentos à vista        
        var params = "acao=salvar&pagamento=avista&forma=" + formaPagamento + "&valor=" + valor + "&notaVenda=" + notaVenda;
        requisicaoHttp("../php/operacoesPagamento.php", params);
    }
}

function trataDados(){
    if(acao=="gerarFormasPagamentoPrincipal"){ //Cria as seleções de formas de pagamento para o pagamento principal
        texto = "<label>Selecione a Forma de Pagamento</label>";
        texto += "<select class='form-control' id='selectPagamentoPrincipal' onchange='confereParcelaPrincipal()'>";
        texto += ajax.responseText;
        texto += "<option value='15'>Compra com duas modalidades de pagamento</option>\n";
        texto += "</select>";
        campoFormasPagamento.innerHTML = texto;
    } else if(acao=="gerarFormasPagamentoEntrada"){ //Cria as seleções de formas de pagamento para o pagamento da entrada
        texto = "<label>Selecione a Forma de Pagamento</label>\n";
        texto += "<select class='form-control' id='selectPagamentoEntrada' onchange='confereParcelaEntrada()'>\n";
        texto += ajax.responseText;
        texto += "</select>";
        campoFormasPagamento.innerHTML = texto;
        
        //gera as formas de pagamento para o valor pendente.
        gerarFormasPagamentoPendente();
    } else if(acao=="gerarFormasPagamentoPendente"){ //Cria as seleções de formas de pagamento para o pagamento pendente
        texto = "<label>Selecione a Forma de Pagamento</label>\n";
        texto += "<select class='form-control' id='selectPagamentoPendente' onchange='confereParcelaPendente()'>\n";
        texto += ajax.responseText;
        texto += "</select>\n";
        campoFormasPagamento.innerHTML = texto;
        gerarValorPendente();
    } else if(acao=="gerarParcelasPrincipal"){
        campoParcela = document.getElementById("campo_parcelado");
        texto = "<label>Selecione o valor das parcelas</label>\n";
        texto += "<select class='form-control' id='selectParcelas'>\n";
        texto += ajax.responseText;
        texto += "</select>\n";
        campoParcela.innerHTML = texto;
    } else if(acao=="gerarParcelasEntrada"){
        texto = "<label>Selecione o valor das parcelas</label>\n";
        texto += "<select class='form-control' id='selectParcelasEntrada'>\n";
        texto += ajax.responseText;
        texto += "</select>\n";
        parcelasEntrada.innerHTML = texto;
    } else if(acao=="gerarParcelasPendencia"){
        campoParcela = document.getElementById("campo_parcelas_pendencia");
        texto = "<label>Selecione o valor das parcelas</label>\n";
        texto += "<select class='form-control' id='selectParcelasPendencia'>\n";
        texto += ajax.responseText;
        texto += "</select>\n";
        campoParcela.innerHTML = texto;
    } else if(acao=="gerarValorPendente"){
        texto = "<label>Valor</label>\n";
        texto += ajax.responseText;
        campoPendente.innerHTML = texto;
    } else if(acao=="salvar"){
        resposta = ajax.responseText;
        if(resposta=="ok"){
            var id = document.getElementById("nota_venda_codificada").value;
            alert("Pagamento registrado no Sistema. \nVocê será redirecionado à página de impressão da nota de venda.");
            window.location = "../php/gerarNotaDeVenda.php?id=" + id;
        } else {
            alert(resposta);
        }
    } else if(acao=="salvarEntrada"){
        resposta = ajax.responseText;
        if(resposta=="ok"){
            salvarPagamentoPendente();
        } else {
            alert(resposta);
        }
    } else if(acao=="salvarPendencia") {
        if(resposta=="ok"){
            var id = document.getElementById("nota_venda_codificada").value;
            alert("Pagamento registrado no Sistema. \nVocê será redirecionado à página de impressão da nota de venda.");
            window.location = "../php/gerarNotaDeVenda.php?id=" + id;
        } else {
            alert(resposta);
        }
    }
}