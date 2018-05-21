<?php
include_once '../cls/formas_pgmntoDAO.class.php';
include_once '../cls/parcelasDAO.class.php';
include_once '../cls/pagamentoDAO.class.php';
include_once '../cls/vendaDAO.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$acao = "";
$valor_total = 0;
$valor_pago = array();
$valor_a_parcelar = 0;
$juros = false;
$valor_restante = 0;

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(isset($_POST['valor_total'])){
    $array = explode(",", $_POST['valor_total']);
    $valor_total = implode(".", $array);
}

if(isset($_POST['valor_pago'])){
    $valor_pago = explode(",", $_POST['valor_pago']);
}

if(isset($_POST['valor_a_parcelar'])){
    $array = explode(",", $_POST['valor_a_parcelar']);
    $valor_a_parcelar = implode(".", $array);
}

if(isset($_POST['juros'])){
    $juros = $_POST['juros'];
}

if(strcmp($acao, "descontar")==0){
    $calculo = 0;
    foreach ($valor_pago as $linha){
        $calculo = $calculo + $linha;
    }
    echo number_format($valor_total-$calculo, 2, ",", "");
} elseif(strcmp($acao, "calcula_parcela")==0){
    header('Content-type: text/xml');
    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    
    if($juros==TRUE){
        $taxa = 0.015; //Taxa de juros atual (1,5% a.m.)
    } else {
        $taxa = 0;
    }
    echo "<parcelas>";
    for($i=1; $i<21; $i++){
        $valorJuros = $valor_a_parcelar * ($taxa*$i);
        $comJuros = $valor_a_parcelar + ($valorJuros);
        $calculo = ($comJuros/$i);
        $parcela = number_format($calculo, 2, ".", "");
    
        echo "<parcela>";
            echo "<valor>";
                echo $parcela;
            echo "</valor>";
        echo "</parcela>";
    }
    echo "</parcelas>";
} elseif(strcmp($acao, "salvar")==0){
    if(isset($_POST['valores']) && isset($_POST['formas']) && isset($_POST['parcelas']) && isset($_POST['venda'])){
        $valores = explode(",", $_POST['valores']);
        $formas = explode(",", $_POST['formas']);
        $parcelas = explode(",", $_POST['parcelas']);
        $nota = $_POST['venda'];
        
        $pagamentoBD = new PagamentoDAO();
        $parcelasBD = new ParcelasDAO();
        
        $inc = 0;
        for($i=0; $i<count($valores); $i++){
            $aux = explode("-", $parcelas[$i]);
            if(!empty($aux[1])){
                $valor_parcela = explode("-", $parcelas[$i])[1];
            } else {
                $valor_parcela = $valores[$i];
            }
            $valores1 = number_format($aux[0] * $valor_parcela, 2, ".", "");
            
            if($pagamentoBD->salvar($nota, $formas[$i], $valores1)){
                $ultimoPagamento = $pagamentoBD->obterIDUltimoPagamento();
                if($parcelasBD->salvar($ultimoPagamento, $aux[0], $valor_parcela)){
                    $inc++;
                }
            }
        }
        
        if($inc==$i){
            echo "OK";
        } else {
            echo "Falha ao registrar pagamento.";
        }
    }
}