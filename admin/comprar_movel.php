<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
//Confere se a autentica��o foi validada.
if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/logoff.php");
}

$id = "";
$nome = "";
$imagem = $imagem =  "<img src='../img/empty.gif' style='width: 90%' />";

if(isset($_REQUEST['id'])){
    $id = base64_decode($_REQUEST['id']);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/comprar_movel.js"></script>
    
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
<body onload="carregarPagina()" class="bg_herdado">
    <form role="form" method="POST">
        <div class="container content">
            <?php
            echo "<input type='text' id='idMovel' class='hidden' value='" . $id . "' />";
            ?>
            <div class="row">
                <h2>Registrar Compra de Móvel</h2>
                <br/>
                <div class="col-sm-4 col-md-3 hidden-xs" id="campoImagem"></div>
                <div class="col-xs-12 col-sm-8 col-md-6">
                    <div id="campoModelo"></div>
                    <label class="spacing">Quantidade comprada:</label>
                    <input type="text" id="campoQtde" class="form-control " placeholder="Digite aqui a quantidade do móvel comprada" autofocus required />
                    <label class="spacing">Valor unitário:</label>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <input type="text" id="campoValor" class="form-control" placeholder="Digite aqui o valor da unidade do móvel" autofocus required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-offset-3 col-md-3 spacing">
                    <input type="button" class="btn btn-lg btn-success btn-block" value="Confirmar" onclick="salvar()" />
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 spacing">
                    <a href="index.php" class="btn btn-lg btn-warning btn-block" title="Cancela o registro da compra e volta à página inicial" >Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
