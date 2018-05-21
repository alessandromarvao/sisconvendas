<?php
include_once '../cls/sessao.class.php';

/* 
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */

$sessao = new Sessao();

//Confere se o usu�rio est� logado no sistema. Se n�o, o explusa da p�gina.
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
        
        <title>Sistema de Controle de Estoque e Vendas - ESPA�O CONFORTO</title>
        
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
    <body class="bg_herdado">
        <div class="container content">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-8">
                    <div class="head-spacing hidden-xs"></div>
                    <div class="row">
                        <div class=" col-xs-12 col-sm-6 spacing">
                            <a href="pesquisar_todos_moveis.php" class="btn btn-lg btn-block btn-default">Pesquisar M�veis no Estoque</a>
                        </div>
                        <div class=" col-xs-12 spacing">
                            <a href="../php/logoff.php" class="btn btn-lg btn-block btn-warning">Encerrar Acesso</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 hidden-xs ">
                    <img src="../img/img_3_1080x1920.jpg" alt="Espa�o Conforto." style="height: 100%" />
                </div>
            </div>
        </div>
    </body>
</html>