<?php
include_once '../cls/sessao.class.php';

/*
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/cadastrar_padrao.js"></script>
    
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
<body class="bg_herdado" onload="carregarPadrao()">
    <div class="container content">
        <div class="row">
            <div class="form-group col-md-6">
                <h2>Cadastro de Senha Padrão</h2>
                <form role="form" method="POST">
                    <br class="visible-md visible-lg" />
                    <label>Senha</label>
                    <input type="text" class="form-control" id="padrao" placeholder="Digite aqui a senha padrão" autofocus required />
                    <br class="visible-md visible-lg" />
                    <div class="row">
                        <div class='col-md-4 col-sm-4 spacing'>
                            <button type='button' class='btn btn-lg btn-block btn-success' title='Confirma o cadastro. Você será encaminhado à página de confirmação' onclick='salvar()'>
                                <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Salvar
                            </button>
                        </div>
                        <div class='col-md-4 col-sm-4 spacing'>
                            <button type="reset" class="btn btn-lg btn-block btn-default" title="Limpa todos os campos preenchidos.">
                                <span class="glyphicon glyphicon-erase"></span> Limpar
                            </button>
<!--                            <input type="reset" class="btn btn-lg btn-block btn-default" value="Limpar" title="Limpa todos os campos preenchidos." />-->
                        </div>
                        <div class='col-md-4 col-sm-4 spacing'>
                            <a href="index.php" class="btn btn-lg btn-block btn-warning" title="Cancela o cadastro e volta à pagina ininical">
                                <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>