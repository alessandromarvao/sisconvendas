var qtde_campos = "qtdeCampos";
var num_campo = 0;
var id_parcelas = "";
var id_total = "valor_total_completo";
var id_calculado = "valor_parcial";
var acao = "";

/**
 * Percorre todos os campos de pagamentos e armazena seus valores em um array.
 * 
 * @param int qtde_campos Quantidade atual de formas de pagamento.
 * @returns void
 */
var percorreValores = function(){
    var campos=_("qtdeCampos").value;
    var array = converteNums(campos);
    calcularValor(array);
};

/**
 * 
 * @param int qtde_campos
 * @returns {Array|array} Valores pagos.
 */
var converteNums = function(qtde_campos){
    var array = [];
    for(i=0; i<qtde_campos; i++){
        var campo_atual = i+1;
        var campo = "valor"+campo_atual;
        var aux = _(campo).value;
        var aux2 = aux.split(",");
        array[i] = aux2.join(".");
    }
    return array;
};

/**
 * 
 * @param int qtde_campos
 * @returns {Array|array} Valores pagos.
 */
var recebe_formas_pagamento = function(qtde_campos){
    var array = [];
    for(i=0; i<qtde_campos; i++){
        var campo_atual = i+1;
        var campo = "forma_"+campo_atual;
        var aux = _(campo).value;
        array[i] = aux;
    }
    return array;
};

/**
 * 
 * @param int qtde_campos
 * @returns {Array|array} Valores pagos.
 */
var confere_parcelas =  function(qtde_campos){
    var array = [];
    var aux = 0;
    for(i=0; i<qtde_campos; i++){
        var campo_atual = i+1;
        var campo = "parcelas_"+campo_atual;
        if(_(campo)){
            aux = _(campo).value;
        } else {
            aux = 1;
        }
        array[i] = aux;        
    }
    return array;
};

/**
 * Recebe o array de valores e repassa ao servidor PHP para calcular o resultado
 * 
 * @param string array
 * @returns void
 */
var calcularValor = function(array){
    var valor_total =  _(id_total).value;
    var valor_recebido = array;
    acao = "descontar";
    requisicaoHttp("../php/concluir_pagamento.php", "acao=" + acao + "&valor_total=" + valor_total + "&valor_pago=" + valor_recebido);
};

/**
 * Cacula o valor da parcela no campo desejado.
 * 
 * @param string id
 * @param int num
 * @param boolean juros
 * @returns void
 */
var criarPagamentoParcelado = function(id, num, juros){
    id_parcelas=id;
    num_campo = num;
    acao = "calcula_parcela";
    var valor = _("valor" + num).value;
    
    requisicaoHttp("../php/concluir_pagamento.php", "acao=" + acao  + "&valor_a_parcelar=" + valor + "&juros=" + juros);
};

var confirmar = function(){
    acao = "salvar";
    if(_("valor_parcial").value=="0,00"){
        var pagamentos = _("qtdeCampos").value;
        var valores_pagos = converteNums(pagamentos);
        var formas_pgmto = recebe_formas_pagamento(pagamentos);
        var parcelas = confere_parcelas(pagamentos);
        var venda = _("nota_venda").value;
        requisicaoHttp("../php/concluir_pagamento.php", "acao=" + acao + "&venda=" + venda + "&valores=" + valores_pagos + "&formas=" + formas_pgmto + "&parcelas=" + parcelas);
    } else {
        alert("Falha ao registrar pagamento. Por favor, verifique o valor a ser pago.");
    }
};

/**
 * 
 * @returns void
 */
function trataDados(){
    if(acao=="descontar"){
        _(id_calculado).value = ajax.responseText;
    } else if(acao=="calcula_parcela"){
        var xml = ajax.responseXML.documentElement.getElementsByTagName("parcela");
        texto = "<br/>";
        texto += "<select id='parcelas_" + num_campo + "' class='form-control'>";
        for(var i=0; i<xml.length; i++){
            var numero = i+1;
            texto += "<option value='" + numero + "-" + xml[i].getElementsByTagName('valor')[0].firstChild.nodeValue +  "'>" + numero +"x de " + xml[i].getElementsByTagName("valor")[0].firstChild.nodeValue + "</option>";
        }
        _("campo_parcelas_" + num_campo).innerHTML = texto;
    } else if(acao=="salvar"){
        if(ajax.responseText=="OK"){
            var caminho1 = window.location.href;
            var caminho_array = caminho1.split("?");
            window.location= "../php/gerarNotaDeVenda.php?" + caminho_array[1];
        } else {
            alert(ajax.responseText);
        }
    }
};