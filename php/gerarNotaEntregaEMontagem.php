<?php
include_once '../cls/movelPossuiVendaDAO.class.php';

$idVenda = 0;

if(isset($_REQUEST['id'])){
    $idVenda = base64_decode($_REQUEST['id']);
}


?>

<html>
    <head>
        <meta charset="Windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
        
        <script src="../js/ajax.js" > </script>
        <script src="js/nota_de_entrega_e_montagem.js" ></script>
        
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
    <body onload="carregarNotas()" class="bg_herdado">
        <?php
        echo "<input type='text' class='hidden' id='id_venda' value='" . $idVenda . "' />";
        ?>
        <div class="container content">
            <!-------------- BOTÃO IMPRIMIR -------------->
            <div class="row hidden-print">
                <div class=" col-sm-4 col-md-2 spacing">
                    <button class="btn btn-lg btn-block btn-default" onclick="imprimir()" id='btn-imprimir'>
                        <span class="glyphicon glyphicon-print"></span> Imprimir
                    </button>
                </div>
                <div class=" col-sm-4 col-md-2 spacing">
                    <a class="btn btn-lg btn-block btn-warning" href="redirecionar.php">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
                    <br/>
                </div>
            </div>
            <!-------------- FIM DO BOTÃO IMPRIMIR -------------->
            
            <!-------------- PÁGINA DE ENTREGA -------------->
            <div id='via1'>
                <!-------------- DADOS DA EMPRESA -------------->
                <div class="row">
                    <!-------------- LOGOMARCA -------------->
                    <div class="col-xs-4 .visible-print-inline">
                        <img src="../img/logo_2_reduzida.png" class="img-responsive" alt='logotipo'/>
                    </div>
                    <!-------------- FIM DA LOGOMARCA -------------->
                    <div class="col-xs-5">
                        <h4 class='text-center'>CONTROLE DE ENTREGA DE MERCADORIAS</h4>
                        <br />
                    </div>
                </div>
                <!-------------- FIM DOS DADOS DA EMPRESA -------------->

                <!-------------- CAMPO DATA -------------->
                <div class="table-responsive">
                    <table class='table table-condensed text-right'>
                        <tr class="small">
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            <td>Nº Nota de Venda:</td>
                            <td><div id="nota_venda"></div></td>
                            <td>|</td>
                            <td>Vendedor:</td>
                            <td><div id='vendedor'></div></td>
                            <td>|</td>
                            <td>Data De Venda:</td>
                            <td><div id='dataVenda'></div></td>
                        </tr>
                    </table>
                </div>
                <!-------------- FIM CAMPO DATA -------------->
                <!-------------- CAMPO CLIENTE -------------->
                <hr class='tabela'/>
                <h5 >Dados do Cliente:</h5>
                <div class="table-responsive">
                    <table class='table table-condensed'>
                        <tr class="small">
                            <td class='col-xs-2'>Nome:</td>
                            <td class='col-xs-10'><div id='nome'></div></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table class='table table-condensed tabela'>
                        <tr class="small">
                            <td>Tel:</td>
                            <td><div id='tel'></div></td>
                            <td>Cel:</td>
                            <td><div id='cel1'></div></td>
                            <td>Cel:</td>
                            <td><div id='cel2'></div></td>
                        </tr>
                        <tr> <!-- TABELA CRIADA PARA SUBLINHAR OS ELEMENTOS SUPERIORES -->
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <!-------------- FIM DO CAMPO CLIENTE -------------->

                <!-------------- DESCRIÇÃO DOS MÓVEIS -------------->
                <h5 class="tabela">Dados da Entrega:</h5>
                <div class="table-responsive">
                    <div id='entrega'></div>
                </div>
                <!-------------- FIM DA DESCRIÇÃO DOS MÓVEIS -------------->
            </div>
            <!-------------- FIM DA PÁGINA DE ENTREGA -------------->
        </div>
        <!-------------- Quebra de Página para Impressão -------------->
        <div class="quebraPagina"></div>
        <!-------------- PÁGINA DE MONTAGEM -------------->
        <div id='2avia' class="container">
                <!-------------- DADOS DA EMPRESA -------------->
                <div class="row">
                    <!-------------- LOGOMARCA -------------->
                    <div class="col-xs-4 .visible-print-inline">
                        <img src="../img/logo_2_reduzida.png" class="img-responsive" alt='logotipo'/>
                    </div>
                    <!-------------- FIM DA LOGOMARCA -------------->
                    <div class="col-xs-5">
                        <h4 class='text-center'>CONTROLE DE MONTAGEM DE MERCADORIAS</h4>
                        <br />
                    </div>
                </div>
                <!-------------- FIM DOS DADOS DA EMPRESA -------------->

                <!-------------- CAMPO DATA -------------->
                <div class="table-responsive">
                    <table class='table table-condensed text-right'>
                        <tr class="small">
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            <td>Nº Nota de Venda:</td>
                            <td><div id="nota_venda1"></div></td>
                            <td>|</td>
                            <td>Vendedor:</td>
                            <td><div id='vendedor1'></div></td>
                            <td>|</td>
                            <td>Data De Venda:</td>
                            <td><div id='dataVenda1'></div></td>
                        </tr>
                    </table>
                </div>
                <!-------------- FIM CAMPO DATA -------------->
                <!-------------- CAMPO CLIENTE -------------->
                <hr class='tabela'/>
                <h5 >Dados do Cliente:</h5>
                <div class="table-responsive">
                    <table class='table table-condensed'>
                        <tr class="small">
                            <td class='col-xs-2'>Nome:</td>
                            <td class='col-xs-10'><div id='nome1'></div></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table class='table table-condensed tabela'>
                        <tr class="small">
                            <td>Tel:</td>
                            <td><div id='tel1'></div></td>
                            <td>Cel:</td>
                            <td><div id='cel11'></div></td>
                            <td>Cel:</td>
                            <td><div id='cel12'></div></td>
                        </tr>
                        <tr> <!-- TABELA CRIADA PARA SUBLINHAR OS ELEMENTOS SUPERIORES -->
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <!-------------- FIM DO CAMPO CLIENTE -------------->

                <!-------------- DESCRIÇÃO DOS MÓVEIS -------------->
                <h5 class="tabela">Dados da Montagem:</h5>
                <div class="table-responsive">
                    <div id='montagem'></div>
                </div>
                <!-------------- FIM DA DESCRIÇÃO DOS MÓVEIS -------------->
            </div>
        <!-------------- FIM DA  PÁGINA DE MONTAGEM -------------->
    </body>
</html>