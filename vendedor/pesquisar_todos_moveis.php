<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
//Confere se a autenticação foi validada.
if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/logoff.php");
}

if(isset($_REQUEST['id'])){
    $sessao->setCliente($_REQUEST['id']);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="Windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/pesquisar_movel.js"></script>
    
    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="../img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../css/signin.css">
</head>
<body onload="teste('obter', 'modelo')" class="bg_herdado">
    <div class="container content">
        <div class="row">
            <div class="form-group col-md-8">
                <h2>Pesquisar Móvel</h2>
                <br />
                <label>Modelo</label>
                <input type="search" name="txtModelo" id="modelo" class="form-control" placeholder="Digite aqui o modelo do móvel" autocomplete="off" onkeyup="teste('obterEstoque', 'modelo')" />
                <br class="visible-md visible-lg" />
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <a href="../php/cancelar_carrinho.php" class="btn btn-lg btn-block btn-warning" title="Cancela a compra e retorna à página inicial">
                    <span class="glyphicon glyphicon-remove"></span>Cancelar</a>
            </div>
        </div>
        <div class="row">
            <div id="tb"></div>
        </div>
    </div>
</body>
</html>

