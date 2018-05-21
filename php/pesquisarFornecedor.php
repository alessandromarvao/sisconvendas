<?php
include_once '../cls/fabricante.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$fornecedor = new Fabricante();

$nome = "";
$resultado = "";

if(isset($_POST['nome'])){
    $nome = $_POST['nome'];
}

if(!empty($nome)){
    $fornecedor->setEmpresa($nome);
    $resultado = $fornecedor->obter();
} else {
    $resultado = $fornecedor->obter();
}