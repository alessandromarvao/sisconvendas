<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
$sessao = new Sessao();

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/redirecionar.php");
}

?>

<html>
<head>
    <meta charset="Windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/pesquisar_notas_vendas.js"></script>
    
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
<body class="">
    <div class="container content">
        <div class="row bg_lft">
            <div class="form-group col-sm-6 col-md-6">
                <h2>Pesquisar Notas de Venda</h2>
                <br/>
                <div class="radio">
                    <label title='Retorna todas as notas de vendas registradas em um dia específico'>
                        <input type='radio' name='radio' id='dia' onclick="consultaCampo()" /> Pesquisar por Dia.
                    </label>
                    <div id="campo_dia" ></div>
                    <br/>
                    <label title='Retorna todas as notas de vendas registradas em um intervalo de data determinado'>
                        <input type='radio' name='radio' id='periodo' onclick="consultaCampo()" > Pesquisar por Intervalo de Datas.
                    </label>
                    <div id="campo_datas"></div>
                    <br/>
                    <label title='Retorna as vendas registradas em um intervalo de data determinado'>
                        <input type='radio' name='radio' id='periodo_vend' onclick="consultaCampo()" > Relatório de vendas por vendedor.
                    </label>
                    <div id="campo_datas_vendedor"></div>
                    <br/>
                    <label title='Retorna as últimas notas de vendas registradas pelo nome do cliente'>
                        <input type="radio" name="radio" id="rd_clientes" onclick="consultaCampo()"> Pesquisar notas de vendas por clientes.
                    </label>
                    <div id="campo_pesquisar_cliente"></div>
                    <br/>
                    <label title='Retorna nota de venda citada'>
                        <input type='radio' name='radio' id='nota' onclick="consultaCampo()" > Exibir Nota de Venda Específica.
                    </label>
                    <div id="campo_nota"></div>
                    <br/>
                    <label title='Retorna todas as notas de vendas registradas no Sistema'>
                        <input type='radio' name='radio' id='todos' onclick="consultaCampo()" > Exibir todas as Notas de Vendas.
                    </label>
                    <div id="campo_total"></div>
                </div>
                <br/>
                <div class="col-md-6">
                    <a href="index.php" class='btn btn-lg btn-block btn-default' title='Retorna à página principal' >
                        <span class="glyphicon glyphicon-remove"></span> Voltar</a>
                </div>
                <div class="col-md-6">
                    <a href="../php/logoff.php" class='btn btn-lg btn-block btn-warning' title='Encerra a sessão e redireciona à página de login' >
                        <span class="glyphicon glyphicon-off"></span> Sair</a>
                </div>
            </div>
            <div class="col-sm-4 col-sm-offset-2 hidden-xs">
                <img src="../img/img_8_1080x1920.jpg" style="height: 100%" />
            </div>
        </div>
    </div>
</body>
</html>
