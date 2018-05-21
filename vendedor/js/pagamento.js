var qtde_campos = "qtdeCampos";
var div = "";
var id = "";
var texto = "";
var i = 0;
var campo_atual = 0;

function _(el){
    return document.getElementById(el);
}

var criar = function (){
    var iterador= parseInt(_(qtde_campos).value) ; //Recebe o valor contido no campo de texto
    i = iterador+1; //Soma o valor por 1.
    _(qtde_campos).value = i; //O campo de texto recebe o novo valor.
    //Cria a nova div
    div = document.createElement("div");
    document.body.appendChild(div);
    //Cria a id para a div
    id = "pagamento" + i;
    div.id= id;
    div.className = "container";
    
    insereElementos(id);
}

var insereElementos = function(id){
    id_txt = "valor" + i;
    texto = "<br/>";
    texto += "<div class=row>";
    texto += "<div class='col-md-6'>";
    texto += "<label>Valor:</label><br/>";
    texto += "<input type='text'class='form-control' id='" + id_txt + "' onkeyup='percorreValores(\"" + _(qtde_campos).value + "\")' /><br/>";
//    texto += "<input type='text' id='" + id_txt + "' onkeyup='calcularValor(\""+ id_txt + "\")'/><br/>";
    texto += "<label>Forma de Pagamento:</label><br/>";
    texto += "<select id='forma_" + i + "' class='form-control' onchange=\'confereFormas(\"forma_" + i + "\")\'>";
    texto += "<option value='1'>Pagamento em Espécie</option>";
    texto += "<option value='2'>Cheque Pré-datado</option>";
    texto += "<option value='3'>Cartão de Crédito</option>";
    texto += "<option value='4'>Cartão de Débito</option>";
    texto += "<option value='5'>Boleto CEF</option>";
    texto += "<option value='6'>Cheque Pré-datado Losango</option>";
    texto += "<option value='7'>Cheque Pré-datado Santander</option>";
    texto += "<option value='8'>Carnê Losango</option>";
    texto += "<option value='9'>Débito em Conta - Losango</option>";
    texto += "<option value='10'>Débito em Conta - Santander</option>";
    texto += "<option value='11'>MoveisCard/Construcard</option>";
    texto += "<option value='12'>Depósito em Conta Corrente</option>";
    texto += "<option value='13'>Cartão BNDES</option>";
    texto += "<option value='14'>BB Crediário</option>";
    texto += "<option value='15'>Pendente</option>";
    texto += "</select>";
    texto += "<div id='campo_parcelas_" + i + "'></div>";
    texto += "</div>";
    texto += "</div>";
    _(id).innerHTML = texto;
    _(id_txt).focus();
}

var confereFormas = function(id){
    var campo_atual = id.split("_")[1];
    var selectFormas = _(id).value;
    if(selectFormas==2 || selectFormas==3 || selectFormas==5 || selectFormas==6 || selectFormas==7 || selectFormas==8 || selectFormas==10 || selectFormas==11){
//        if(selectFormas==8) {
//            criarPagamentoParcelado(id, campo_atual, 1);
//        } else {
//            criarPagamentoParcelado(id, campo_atual, 0);
//        }
        criarPagamentoParcelado(id, campo_atual, 0);
    } else {
        _("campo_parcelas_" + campo_atual).innerHTML = "";
    }
}