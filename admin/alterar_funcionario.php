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

$txtLogin="<input type='text' class='form-control' value='" . $login . "' name='txtLogin' id='login' readonly />";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
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
    
    <script src="../js/ajax.js"></script>
    <script src="js/alterar_usuario.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../css/signin.css">
</head>
<body class="bg_herdado" onload="carregar()">
    <div class="container content">
        <div class="row">
            <div class="col-md-6">
                <h2>Administrar acesso do funcionário</h2>
                <div class="col-md-12">
                    <label class="spacing">Login:</label>
                    <?php
                    echo $txtLogin;
                    ?>
                    <label class="spacing">Nome:</label>
                    <input type='text' class='form-control' id='nome' readonly />
                    <label class='spacing'>Função:</label>
                    <input type='text' class='form-control' id='cargo' readonly />
                    <label class='spacing'>Escolha a alteração desejada</label>
                    <select class='form-control' id='opcao' >
                        <option value='1'>Desbloquear senha do usuário</option>
                        <option value='2'>Bloquear acesso do usuário</option>
                        <option value='3'>Liberar acesso do usuário</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <br/>
                    <button class="btn btn-lg btn-block btn-success" onclick="salvar()">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Salvar
                    </button>
                </div>
                <div class="col-md-4">
                    <br/>
                    <a href="index.php" class="btn btn-lg btn-block btn-warning" title="Retornar à página principal">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                    </a>
                </div>
            </div>
            <div class="row">
                <div class='col-md-4 col-md-offset-2 hidden-sm hidden-xs'>
                    <img alt="imagem" src="../img/img_25_1080x1920.jpg" class="img-responsive" style='width: 100%'/>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
