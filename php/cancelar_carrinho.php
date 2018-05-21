<?php
include_once '../cls/carrinho_compras.class.php';
include_once '../cls/sessao.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

//inicia operações com sessão
$sessao = new Sessao();

//inicia operações do carrinho de compras.
$carrinho = new Carrinho_compras();

//obtem carrinho de compras do cliente
$resultado = $carrinho->obter();

//apaga o carrinho de compras do cliente
$carrinho->removerPorCliente($sessao->getCliente());

$sessao->limparCliente();

header("location: redirecionar.php");