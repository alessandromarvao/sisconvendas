<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/redirecionar.php");
}

$acao = "";
$data1 = "";
$data2 = "";
$nota = "";

if(isset($_REQUEST['acao'])){
    $acao = "<input type='text' class='hidden' id='acao' value='" . base64_decode($_REQUEST['acao']) . "' readonly />\n";
}

if(isset($_REQUEST['data1'])){
    $data1 = "<input type='text' class='hidden' id='data1' value='" . base64_decode($_REQUEST['data1']) . "' readonly />\n";
}

if(isset($_REQUEST['data2'])){
    $data2 = "<input type='text' class='hidden' id='data2' value='" . base64_decode($_REQUEST['data2']) . "' readonly />\n";
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/pesquisar_notas.js"></script>
    
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
<body class='bg_cntr' onload="carregar()">
    <?php
    echo $acao;
    echo $data1;
    echo $data2;
    ?>
    <div class="hidden-print col-xs-12">
        <div class="col-xs-2">
            <button class="btn btn-lg btn-block btn-default" onclick="imprimir()">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir
            </button>
        </div>
        <div class="col-xs-2">
            <a class="btn btn-lg btn-block btn-warning" href="index.php">
                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar
            </a>
        </div>
    </div>
    <div class='lead'>
        <div class="text-center spacing">
            RELATÓRIO DE VENDAS: 
            <div id="periodo" class='underlined'></div>
        </div>
        <br />
        <div class="text-center" >
        
        <div id="resultado"></div>
        </div>
    </div>
</body>
</html>