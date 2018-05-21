<?php
include_once '../cls/carrinho_compras.class.php';
include_once '../cls/sessao.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

//inicia opera��es com sess�o
$sessao = new Sessao();

//inicia opera��es do carrinho de compras.
$carrinho = new Carrinho_compras();

//obtem carrinho de compras do cliente
$resultado = $carrinho->obter();

//apaga o carrinho de compras do cliente
$carrinho->removerPorCliente($sessao->getCliente());

$sessao->limparCliente();

header("location: redirecionar.php");