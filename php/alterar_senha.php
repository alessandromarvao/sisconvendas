<?php
include_once '../cls/usuario.class.php';

$login = "";

if($_GET['id']){
    $login = base64_decode($_GET['id']);
}

$usr = new Usuario($login);

$resultado = $usr->obter();
$nome = $resultado['nome'];
$campoLogin = "<input type='text' name='txtLogin' class='form-control' value='" . $login . "' readonly />";

?>

<html>
<head>
    <meta charset="Windows-1252">
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
    
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../css/signin.css">
</head>
<body class="bg_herdado">
    <div class="container content">
        <div class="row">
            <div class="form-group col-sm-10 col-md-6">
                <h2>Alterar Senha</h2>
                <br/>
                <h4>Olá, <?php echo $nome ?>. Você está realizando o acesso utilizando a senha padrão. Por favor, altere sua senha.</h4>
                <form role="form" action="../php/cadastrar_senha.php" method="POST">
                    <br />
                    <label>Login</label>
                    <?php
                    echo $campoLogin;
                    ?>
                    <br/>
                    <input type="text" name='txtOpcao' value='alterar senha' class="hidden">
                    <label>Nova Senha</label>
                    <input type="password" name="txtPwd" class="form-control" placeholder="Digite aqui a sua nova senha" />
                    <br />
                    <div class="row">
                        <br class="visible-xs visible-sm" />
                        <div class='col-md-4 col-sm-12 spacing'>
                            <input type="submit" class="btn btn-lg btn-block btn-success" value="Continuar" title="Confirma o cadastro. Você será encaminhado à página de confirmação"/>
                        </div>
                        <div class='col-md-4 col-sm-12 spacing'>
                            <input type="reset" class="btn btn-lg btn-block btn-default" value="Limpar" title="Limpa todos os campos preenchidos." />
                        </div>
                        <div class='col-md-4 col-sm-12 spacing'>
                            <a href="logoff.php" class="btn btn-lg btn-block btn-danger" title="Cancela o cadastro e volta à pagina de login">Sair</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4 col-sm-offset-2 hidden-xs hidden-sm">
                <img src="../img/img_12_1080x1920.jpg" class="img-responsive" style="height: 100%; position: fixed" />
            </div>
        </div>
    </div>
</body>
</html>