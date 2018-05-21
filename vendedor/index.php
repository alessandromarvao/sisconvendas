<?php
include_once '../cls/sessao.class.php';

/* 
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */

$sessao = new Sessao();

//Confere se o usuário está logado no sistema. Se não, o explusa da página.
if($sessao->situacaoOK()==FALSE){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/redirecionar.php");
}

?>

<html>
    <head>
        <meta charset="Windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
        
        <script src="../js/ajax.js"></script>
        <script src='js/index.js'></script>
        
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
    <body class="bg_herdado" onload="carregar()">
        <div class="container content">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-8">
                    <div class="head-spacing hidden-xs"></div>
                    <div class="row">
                        <div class=" col-xs-12 col-sm-6 spacing" id='btn1'>
                            <a href="cadastrar_cliente.php" class="btn btn-lg btn-block btn-default" title='Realiza o cadastro de um cliente no Sistema. Caso o mesmo já exista, altera suas informações registradas'>Cadastrar Cliente</a>
                        </div>
                        <div class=" col-xs-12 col-sm-6 spacing" id='btn2'>
                            <a href="pesquisar_cliente.php" class="btn btn-lg btn-block btn-default" title='Seleciona os clientes para registrar a venda de móveis para o mesmo'>Registrar Venda</a>
                        </div>
                        <div class=" col-xs-12 spacing" id='btn3'>
                            <a href="pesquisar_todos_moveis.php" class="btn btn-lg btn-block btn-default" title='Exibe a lista completa dos móveis registrados no Sistema.'>Pesquisar Móveis no Estoque</a>
                        </div>
                        <div class=" col-xs-12 spacing">
                            <a href="../php/logoff.php" class="btn btn-lg btn-block btn-warning" title="Encerra a sessão e retorna à página de login." >
                                <span class="glyphicon glyphicon-off"></span> Encerrar Acesso
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 hidden-xs ">
                    <img src="../img/img_3_1080x1920.jpg" alt="Espaço Conforto." style="height: 100%; position: fixed" />
                </div>
            </div>
        </div>
    </body>
</html>