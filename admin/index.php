<?php
include_once '../cls/cliente.class.php';
include_once '../cls/sessao.class.php';
include_once '../cls/movel.class.php';

/* 
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */

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
        
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../css/signin.css">
    </head>
    <!-- DESENVOLVIDO POR ALESSANDRO MARVÃO [alessandromarvao@gmail.com] -->
    <body class="bg_herdado">
        <div class="container content">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="hidden-xs"></div>
                    <div class="row">
                        <div class="col-md-12 spacing">
                            <?php
                            $cliente = new Cliente();
                            $aniversariantes = $cliente->obterAniversariantesDoDia();
                            if(count($aniversariantes)==1){
                                echo "<a href='pesquisar_aniversariantes_do_dia.php' class='btn btn-lg btn-block btn-success' title='clique aqui para saber mais detalhes.' >Você possui um cliente fazendo aniversário hoje, confira!</a>";
                            } elseif(count($aniversariantes)>1){
                                echo "<a href='pesquisar_aniversariantes_do_dia.php' class='btn btn-lg btn-block btn-success' title='clique aqui para saber mais detalhes.' >Você possui " . count($aniversariantes) . " clientes fazendo aniversário hoje, Confira!</a>";
                            }
                            ?>
                        </div>
                        <div class="col-md-12 spacing">
                            <?php
                            $estoque = new movel();
                            $limite = $estoque->obterEstoqueBaixo();
                            if($limite <> 0){
                                echo "<a href='pesquisar_limite_movel_estoque.php' class='btn btn-lg btn-block btn-success' title='clique aqui para saber mais detalhes.' >O estoque de um ou mais móveis está esgotando</a>";
                            }
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="cadastrar_funcionario.php" class="btn btn-lg btn-block btn-default" title="Adiciona um novo funcion�rio. Caso o mesmo já exista, altera as suas informa��es pessoais." >Cadastrar Funcionário</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="pesquisar_usuario.php" class="btn btn-lg btn-block btn-default" title="Atualiza a situação do usuário no Sistema" >Bloquear ou desbloquear acesso</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="cadastrar_fornecedor.php" class="btn btn-lg btn-block btn-default" title="Adiciona um novo Fornecedor. Caso o mesmo já exista, altera as suas informações." >Cadastrar Fornecedor</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="consultar_fornecedor.php" class="btn btn-lg btn-block btn-default" title="Consulta os fornecedores registrados e altera suas informações." >Consultar Fornecedores</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="cadastrar_movel.php" class="btn btn-lg btn-block btn-default" title="Adiciona um novo m�vel no Sistema." >Cadastrar Móvel</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="selecionar_movel_compra.php" class="btn btn-lg btn-block btn-default" title="Registra a compra de um m�vel e adiciona a quantidade comprada no estoque." >Registrar Compra de Móvel</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="pesquisar_movel.php" class="btn btn-lg btn-block btn-default" title="Consulta os m�veis registrados no Sistema." >Pesquisar Móveis</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="pesquisar_moveis_vendidos.php" class="btn btn-lg btn-block btn-default" title="Consulta a venda de m�veis (todos, por per�odo, por vendedor e por Cliente)." >Relatório de Vendas</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="relatorio_compras.php" class="btn btn-lg btn-block btn-default" title="Consulta a compra de m�veis (todos, por per�odo, por empresa e por Móvel)." >Pesquisar Compra de Móveis</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="cadastrar_senha_padrao.php" class="btn btn-lg btn-block btn-default" title="Cria ou altera, caso j� exista, uma senha inicial para os usuários." >Cadastrar Senha Padrão</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="pesquisar_cliente.php" class="btn btn-lg btn-block btn-default" title="Consulta os clientes registrados no Sistema." >Pesquisar Clientes</a>
                        </div>
                        <div class="col-xs-12 col-md-6 spacing">
                            <a href="pesquisar_clientes_aniversariantes.php" class="btn btn-lg btn-block btn-default" title="Consulta os clientes registrados no Sistema que realizam anivers�rio no m�s atual." >Pesquisar Aniversariantes do Mês</a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 spacing">
                            <a href="../php/logoff.php" class="btn btn-lg btn-block btn-warning" title="Encerra a sessão e retorna à página de login." >
                                <span class="glyphicon glyphicon-off"></span> Encerrar Acesso
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1 hidden-sm hidden-xs">
                    <img src="../img/img_1_1080x1920.jpg" alt="Espa�o Conforto." style="height: 100%; position:fixed" />
                </div>
            </div>
        </div>
    </body>
</html>