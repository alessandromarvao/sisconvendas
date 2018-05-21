<?php
include_once '../cls/sessao.class.php';
include_once '../cls/pagamentoDAO.class.php';
include_once '../cls/vendaDAO.class.php';

/* 
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */

//Inicia as opera��es da sess�o.
$sessao = new Sessao();

//Confere se o usu�rio est� logado no sistema. Se n�o, o explusa da p�gina.
if($sessao->situacaoOK()==FALSE){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/redirecionar.php");
}

//Vari�vel a receber a nota de venda
$idVenda = 0;
$idCodificado = "";
if(isset($_REQUEST['id'])){
    $idVenda = base64_decode($_REQUEST['id']);
    $idCodificado = $_REQUEST['id'];
} else {
    header("location: ../php/redirecionar.php");
}


//confere se esta venda j� est� paga, se sim, redireciona � p�gina principal
if(!empty($idVenda)){
    $pagamento = new PagamentoDAO();
    if(count($pagamento->obterPorNotaDeVenda($idVenda))>0){ //Obt�m lista de pagamentos por nota de Venda e confere se o resultado � maior que 0
        header("location: index.php"); //Redireciona � p�gina principal
    }
}

$campoVenda = "<input type='text' class='form-control' id='nota_venda' value='" . $idVenda . "' readonly />";
$campoCodificado = "<input type='text' class='hide' id='nota_venda_codificada' value='" . $idCodificado . "' readonly />";

//Inicia as opera��es de Venda
$venda = new VendaDAO();

//recupera informa��es da venda desejada
$resVenda = $venda->obterPorNotaDeVenda($idVenda);

$valor = number_format($resVenda['valor_total'], 2, ",", "");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
        
        <script src="../js/ajax.js"></script>
        <script src="js/ajax_pagamento.js"></script>
        <script src="js/pagamento.js"></script>
        
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
    <body class="bg_herdado" onload="criar()">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Pagamento:</h2>
                    <input type="text" value="0" class="hidden" id="qtdeCampos"/>
                    <label>Valor total:</label>
                    <?php
                    echo "<input type='text' value='" . $resVenda['nota_venda'] . "' class='hidden' id='nota_venda' readonly style='display: none' /> <br/>";
                    echo "<input type='text' value='" . $valor . "' id='valor_total_completo' class='form-control' readonly /> <br/>";
                    echo "<label>Valor a ser pago:</label>";
                    echo "<input type='text' value='" . $valor . "' class='form-control' id='valor_parcial' readonly /> <br/>"
                    ?>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-3">
                    <button type="button" class="btn btn-lg btn-block btn-default" onclick="criar()" title="Cria campo para armazenar outra forma de pagamento">Novo</button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-lg btn-block btn-success" title="Confirma o pagamento da compra" onclick="confirmar()">Confirmar </button>
                </div>
            </div>
        </div>
    </body>
</html>