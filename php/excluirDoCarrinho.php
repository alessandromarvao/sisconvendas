<?php
include_once '../cls/carrinho_compras.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$acao = "";

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(strcmp($acao, "excluir")==0){
    $carrinho = new Carrinho_compras();

    $cliente = "";
    $movel = "";

    if(isset($_POST['cliente'])){
        $cliente = $_POST['cliente'];
    }

    if(isset($_POST['movel'])){
        $movel = $_POST['movel'];
    }

    if($carrinho->remover($cliente, $movel)){
        echo "ok";
    } else {
        echo "fail";
    }
} elseif (strcmp($acao, "calcularDesconto")==0){
    $desconto = "";
    $total = "";
    
    if(isset($_POST['desconto'])){
        $numero = $_POST['desconto'];
        $lista = explode(",", $numero);
        $string = implode(".", $lista);
        $num = (double) $string;
        $desconto = number_format($num, 2, ".", "");
    }
    
    if(isset($_POST['total'])){
        $numero = $_POST['total'];
        $lista = explode(",", $numero);
        $string = implode(".", $lista);
        $num = (double) $string;
        $total = number_format($num, 2, ".", "");
    }
    
    $calculo = $total - $desconto;
    echo $calculo;
}
