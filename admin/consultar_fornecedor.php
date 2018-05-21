<?php 
include_once '../cls/sessao.class.php';

$sessao = new Sessao();

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/redirecionar.php");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="Windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/consultar_fornecedor.js"></script>
    
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
<body onload="obter('todos')" class='bg_herdado'>
    <div class="container content">
        <div class="row">
            <h2>Pesquisar Fornecedor</h2>
            <div class="form-group col-md-4">
                <br />
                <label>Empresa:</label>
                <input type="search" id="fornecedor" class="form-control" placeholder="Digite aqui a razão social da empresa" onkeyup="obter('empresa')" />
            </div>
            <div class="form-group col-md-4 col-md-offset-1">
                <br />
                <label>Representante:</label>
                <input type="search" id="representante" class="form-control" placeholder="Digite aqui a razão social da empresa" onkeyup="obter('representante')" />
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <a href="index.php" class="btn btn-lg btn-block btn-default" title="Retornar à página inicial">
                    <span class="glyphicon glyphicon-remove"></span> Voltar</a>
            </div>
            <div class="col-sm-4 col-md-3">
                <a href="../php/logoff.php" class="btn btn-lg btn-block btn-warning" title="Encerra a sessão e retorna à página de login">
                    <span class="glyphicon glyphicon-off"></span> Sair</a>
            </div>
        </div>
    </div>
    <br/>
    <div class="container">
        <div class="row">
            <form class="form-group-lg">
                <div id="tb"></div>
            </form>
        </div>
    </div>
</body>
</html>
