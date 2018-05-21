<?php
include_once '../cls/formas_pgmntoDAO.class.php';
include_once '../cls/pagamentoDAO.class.php';
include_once '../cls/parcelasDAO.class.php';


// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$formas = new Formas_pgmntoDAO();

$resFormas = $formas->obterTodos();

$acao = "";
$valor = "";
$pagamento = "";
$forma = "";
$parcelas = "";
$valorEntrada = 0.0;
$notaVenda = "";
$juros = "";

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(isset($_POST['valor'])){
    $array = explode(",", $_POST['valor']);
    $num = (double) implode(".", $array);
    $valor = number_format($num, 2, ".", "");
}

if(isset($_POST['pagamento'])){
    $pagamento = $_POST['pagamento'];
}

if(isset($_POST['forma'])){
    $forma = $_POST['forma'];
}

if(isset($_POST['parcelas'])){
    $parcelas = (int) $_POST['parcelas'];
}

if(isset($_POST['juros'])){
    $juros = $_POST['juros'];
}

if(isset($_POST['valorEntrada'])){
    $array = explode(",", $_POST['valorEntrada']);
    $num = (double) implode(".", $array);
    $valorEntrada = number_format($num, 2, ".", "");
}

if(isset($_POST['notaVenda'])){
    $notaVenda = $_POST['notaVenda'];
}

if(strcmp($acao, "gerarFormasPagamentoPrincipal")==0 || strcmp($acao, "gerarFormasPagamentoEntrada")==0 || strcmp($acao, "gerarFormasPagamentoPendente")==0){ //Gera as seleções de forma de pagamento principal
    foreach ($resFormas as $linha){
        echo utf8_encode("<option value='" . $linha['id_forma_pgmto'] . "'>" . $linha['forma_pgmnto'] . "</option>\n");
    }
} elseif(strcmp($acao, "gerarParcelas")==0){
    $taxa = 0;
    
    //Calcula taxa de juros
    if(strcmp($juros, "s")==0){
        $taxa = 0.015; //Taxa de juros atual (1,5% a.m.)
    }
    
    for($i=1; $i<11; $i++){
        $valorJuros = $valor * ($taxa*$i);
        $comJuros = $valor + ($valorJuros);
        $calculo = ($comJuros/$i);
        
//        $calculo = $valor / $i;
        $parcela = number_format($calculo, 2, ".", "");
        echo "<option value=$i>" . $i . "x de " . $parcela . "</option>\n";
    }
} elseif(strcmp($acao, "gerarValor")==0){
    $valorCalculado = $valor - $valorEntrada;
    echo "<input type='text' class='form-control' id='valor_pendente' value='" . number_format($valorCalculado, 2, ",", "") . "' readonly />\n";
} elseif(strcmp($acao, "salvar")==0){
    $BDpagamento = new PagamentoDAO();
    
    if($BDpagamento->salvar($notaVenda, $forma, $valor)){
        if(strcmp($pagamento, "parcelado")==0){
            $BDParcelas = new ParcelasDAO();
            $ultimoPagamento = $BDpagamento->obterIDUltimoPagamento();
            $calculo = $valor / $parcelas;
            $parcela = number_format($calculo, 2, ".", "");
            
            if($BDParcelas->salvar($ultimoPagamento, $parcelas, $parcela)){
                echo "ok";
            } else {
                echo "Falha ao salvar parcelamento no Banco de Dados.";
            } 
        } else {
            echo "ok"; 
        }
    } else {
        echo "Falha ao salvar o pagamento no Banco de Dados.";
    }
}