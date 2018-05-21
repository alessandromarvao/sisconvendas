<?php
include_once '../cls/sessao.class.php';
include_once '../cls/vendaDAO.class.php';

$sessao = new Sessao();
//Confere se a autentica��o foi validada.
if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}
$id = 0;

$vendaDAO = new VendaDAO();

if(isset($_REQUEST['id'])){
    $id = base64_decode($_REQUEST['id']);
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
        
        <script src="../js/ajax.js" > </script>
        <script src="js/notaVenda.js" ></script>
        
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
    <body onload="carregarNotaDeVenda()">
        <?php
        echo "<input type='text' class='hidden' id='id_venda' value='" . $id . "' readonly />\n";
        ?>
        <div class="container content">
            <!-------------- BOT�O IMPRIMIR -------------->
            <div class="row hidden-print">
                <div class=" col-sm-4 col-md-2 spacing">
                    <button class="btn btn-lg btn-block btn-default" onclick="imprimir()">
                        <span class="glyphicon glyphicon-print"></span> Imprimir
                    </button>
                </div>
                <div class=" col-sm-4 col-md-2 spacing">
                    <button class="btn btn-lg btn-block btn-warning" onclick="cancelar()">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </button>
                    <br/>
                </div>
            </div>
            <!-------------- FIM DO BOTÃO IMPRIMIR -------------->
            <div id='via1'>
                <!-------------- DADOS DA EMPRESA -------------->
                <div class="row">
                    <!-------------- LOGOMARCA -------------->
                    <div class="col-xs-4 .visible-print-inline">
                        <img src="../img/logo_2_reduzida.png" class="img-responsive" alt='logotipo'/>
                    </div>
                    <!-------------- FIM DA LOGOMARCA -------------->
                    <div class="col-xs-5 tabela">
                        <h3 class='text-center'>Espaço Conforto</h3>
                        <div class='text-center margemSuperior'>
                            <small>A loja dos seus sonhos</small>
                        </div>
                        <div class='text-center'>
                            <small>Av. Jerônimo de albuquerque, 304B, Angelim</small>
                        </div>
                        <div class='text-center'>
                            <small>Tel: (98)3245-7474</small>
                            <small>Tel: (98)3259-3445</small>
                        </div>
                    </div>
                </div>
                <!-------------- FIM DOS DADOS DA EMPRESA -------------->

                <!-------------- CAMPO DATA -------------->
                <div class="table-responsive">
                    <table class='table table-condensed text-right'>
                        <tr class="">
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            <td class="small">Nota de Venda:</td>
                            <td class="small"><div id="nota_venda"></div></td>
                            <td>|</td>
                            <td class="small">Vendedor:</td>
                            <td class="small"><div id='vendedor'></div></td>
                            <td>|</td>
                            <td class="small">Data:</td>
                            <td class="small"><div id='data'></div></td>
                            <td>|</td>
                            <td class="small">Hora:</td>
                            <td class="small"><div id='hora'></div></td>
                        </tr>
                    </table>
                </div>
                <!-------------- FIM CAMPO DATA -------------->
                <!-------------- CAMPO CLIENTE -------------->
                <hr class='tabela'/>
                <h5 >Dados do Cliente:</h5>
                <div class="table-responsive">
                    <table class='table table-condensed'>
                        <tr class="">
                            <td class='col-xs-2'>Cliente</td>
                            <td class='col-xs-10'><div id='nome'></div></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="">
                            <td class='col-xs-2'>Endereço</td>
                                <td class='col-xs-10'><div id='endereco'></div></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table class='table table-condensed tabela'>
                        <tr class="">
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

                <!-------------- DESCRI��O DOS M�VEIS -------------->
                <h5 class="margemSuperior">Mercadoria:</h5>
                <div class="table-responsive">
                    <div id='moveis'></div>
                    <table class="table table-condensed text-right tabela">
                        <tr class="small">
                            <td class='small'>Valor Total:</td>
                            <td class='small'>Desconto:</td>
                            <td class='small'>Valor Final:</td>
                        </tr>
                        <tr class="small">
                            <td class='small'><div id='total_bruto'></div></td>
                            <td class='small'><div id='desconto'></div></td>
                            <td class='small'><div id='total'></div></td>
                        </tr>
                    </table>
                </div>
                <!-------------- FIM DA DESCRI��O DOS M�VEIS -------------->
                <hr class="tabela" />
                <!-------------- FORMAS DE PAGAMENTO -------------->
                <h5>Formas de Pagamento:</h5>
                <div class="table-responsive">
                    <div id='formas_pagamento'></div>
                </div>
                <!-------------- FIM DAS FORMAS DE PAGAMENTO -------------->
            </div>
        </div>
        
        <!-------------- Quebra de P�gina para Impress�o -------------->
        
        <div class="quebraPagina"></div>
       
        <!-------------- FIM Quebra de P�gina para Impress�o -------------->
        <div class="hidden-lg hidden-md hidden-sm">
            <div> 2ª VIA </div>
            <div id="via2"></div>
        </div>
    </body>
</html>
