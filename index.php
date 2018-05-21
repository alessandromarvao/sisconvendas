<?php
include_once 'cls/sessao.class.php';

$sessao = new Sessao();
$div = "";

$situacao = $sessao->validaLogin();

if($situacao==0){
    $div = "<div class='text-default'><h5>Usuário inexistente.</h5></div>";
} elseif($situacao==1){
    $div = "<div class='text-default'><h5>Senha incorreta</h5></div>";
} elseif($situacao==2){
    header("location: encaminhar.php");
}

//Confere se o usuário está logado no sistema. Se não, o explusa da página.
if($sessao->situacaoOK()==TRUE){
    header("location: encaminhar.php");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas</title>
        
        <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="css/signin.css">
    </head>
    <body class="bg_herdado">
        <div class="container">
            <div class="head-spacing"></div>
            <form action="php/signin.php" method="POST" class="form-signin bg_login">
                <img class="form-signin-heading img-responsive" src="img/logo.png" />
                <div class="control-group">
                    <label class="sr-only" for="usr">Login</label>
                    <input type="text" name="usr" class="form-control" placeholder="Login do usuário" autofocus autocomplete="off" required />
                    <?php echo $div; ?>
                    <label for="pwd" class="sr-only">Senha</label>
                    <input type="password" name="pwd" class="form-control" placeholder="Senha do usuário" required />
                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Entrar"/>
                </div>
            </form>
        </div>
    </body>
</html>
