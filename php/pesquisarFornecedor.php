<?php
include_once '../cls/fabricante.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

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