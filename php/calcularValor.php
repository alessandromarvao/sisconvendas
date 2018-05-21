<?php
include_once '../cls/movel.class.php';
include_once '../cls/cliente.class.php';
include_once '../cls/sessao.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$acao = "";
$qtde = "";
$valor = "";
$id = 0;

if(isset($_POST['acao']))
    $acao = $_POST['acao'];

if(isset($_POST['qtde']))
    $qtde = $_POST['qtde'];

if(isset($_POST['id']))
    $id = base64_decode ($_POST['id']);

if(isset($_POST['valor'])){
    $valor = $_POST['valor'];
    
    $lista = explode(",", $valor);
    $string = implode(".", $lista);
    $numero = (double) $string;
}

if(strcmp($acao, "carregar")==0){
    
} elseif(strcmp($acao, "somar") == 0){
    $multi = $qtde * $numero;
    $lista = explode(",", $multi);
    $string = implode(".", $lista);
    $total = (double) $string;
    
    echo number_format($total, 2, ",", "");
} elseif(strcmp($acao, "criarEndereco")==0){
    header('Content-type: text/xml');
    echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
    $sessao = new Sessao();
    $cliente = new Cliente($sessao->getCliente());
    echo "<cliente>";
    $resultado = $cliente->obter();
    $end = utf8_encode($resultado['endereco'] . ", " . $resultado['bairro']);
    echo "<endereco>";
        echo $end;
    echo "</endereco>";
    echo "<referencia>";
        echo utf8_encode($resultado['pto_referencia']);
    echo "</referencia>";
    echo "</cliente>";
}
