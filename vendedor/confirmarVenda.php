<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
//Confere se a autentica��o foi validada.
if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/logoff.php");
}

?>

<html>
    <head>
        <meta charset="Windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas - ESPA�O CONFORTO</title>
        
        <script src="../js/ajax.js" > </script>
        <script src="js/carrinho.js" ></script>
        
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
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-12 spacing">
                        </div>
                        <div class="col-sm-12 spacing">
                        </div>
                        <div class=" col-sm-4 spacing">
                            <a href="../php/logoff.php" class="btn btn-lg btn-block btn-success hidden-print">Confirmar</a>
                        </div>
                        <div class=" col-sm-4 spacing">
                            <a href="../php/limparCarrinhoDeCompras.php" class="btn btn-lg btn-block btn-warning hidden-print">Cancelar Compra</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm ">
                    <img src="../img/img_25_1080x1920.jpg" alt="Espa�o Conforto." style="height: 100%" />
                </div>
            </div>
        </div>
    </body>
</html>