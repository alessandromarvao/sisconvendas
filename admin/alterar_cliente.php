<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/redirecionar.php");
}

$login = "";

if(isset($_GET['id'])){
    $login = base64_decode($_GET['id']);
}

$txtLogin="<input type='text' class='form-control' value='" . $login . "' id='txtCPF' readonly />\n";
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/alterar_cliente.js"></script>
    <script src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.maskedinput.js"/></script>
    <script>
        $(document).ready(function(){
            $(".celular").mask("(99)99999-9999");
            $("#txtTel").mask("(99)9999-9999");
            $("#txtCEP").mask("99999-999");
            $("#txtDataNascimento").mask("99/99/9999");
        });
    </script>
    
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
            <div class="col-xs-12 col-md-6">
                <h2>Alterar informações do Cliente</h2>
                <label class="spacing">CPF:</label>
                <?php
                echo $txtLogin;
                ?>
                <label class="spacing">Nome:</label>
                <input type='text' class='form-control' id='txtNome' />
                <label class="spacing">Email:</label>
                <input type='text' class='form-control' id='txtEmail' />
                <label class="spacing">Data de nascimento:</label>
                <input type='text' class='form-control' id='txtDataNascimento' />
                <label class='spacing'>Endereço:</label>
                <input type='text' class='form-control' id='txtEnd' />
                <label class='spacing'>Bairro:</label>
                <input type='text' class='form-control' id='txtBairro' />
                <label class='spacing'>Ponto de referência:</label>
                <input type='text' class='form-control' id='txtRef' />
                <label class='spacing'>CEP (Opcional):</label>
                <input type='text' class='form-control' id='txtCEP' />
                <label class='spacing'>Telefone Fixo (Opcional):</label>
                <input type='text' class='form-control' id='txtTel' />
                <label class='spacing'>Telefone Celular (Opcional):</label>
                <input type='text' class='form-control celular' id='txtCel1' />
                <label class='spacing'>Telefone Celular (Opcional):</label>
                <input type='text' class='form-control celular' id='txtCel2' />
                <br />
                <div class="col-md-4 spacing">
                    <button class="btn btn-lg btn-block btn-success" title="Altera as informações do cliente e redireciona à página de confirmação." onclick="salvar()">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Alterar
                    </button>
                </div>
                <div class="col-md-4 spacing">
                    <a href="index.php" class="btn btn-lg btn-block btn-default" title="Retornar à pàgina principal">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                    </a>
                </div>
                <div class="col-md-4 spacing">
                    <a href="../php/logoff.php" class="btn btn-lg btn-block btn-warning" title="Encerra a sessão atual e redireciona à página de login.">
                        <span class="glyphicon glyphicon glyphicon-off" aria-hidden="true"></span> Sair
                    </a>
                </div>
            </div>
            <div class="col-sm-3 col-sm-offset-2 hidden-xs">
                <img src="../img/img_25_1080x1920.jpg" class="img-responsive img_lateral" style="height: 100%; position: fixed" />
            </div>
        </div>
        <br/>
    </div>
</body>
</html>
