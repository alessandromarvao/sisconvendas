<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
//Confere se a autentica��o foi validada.

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}
?>


<html>
    <head>
        <meta charset="UTF-8">
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
        $id = 0;
        if(isset($_GET['id'])){
            $id = base64_decode($_GET['id']);
        }
        echo "<input type='text' class='hidden' id='id_venda' value='" . $id . "' readonly />\n";
        ?>
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
        <div id="entrega">
            <!-------------- DADOS DA EMPRESA -------------->
            <div class="row small">
                <!-------------- LOGOMARCA -------------->
                <div class="col-xs-4 .visible-print-inline">
                    <img src="../img/logo_2_reduzida.png" class="img-responsive" alt='logotipo' style="width:110px"/>
                </div>
                <!-------------- FIM DA LOGOMARCA -------------->
                <div class="col-xs-4 tabela small">
                    <h3 class='text-center'>Espaço Conforto</h3>
                    <div class='text-center margemSuperior'>
                        <small>Av. Jerônimo de albuquerque, 304B, Angelim</small>
                    </div>
                    <div class='text-center'>
                        <small>Tel: (98)3245-7474</small>
                        <small>Tel: (98)3259-3445</small>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="col-xs-1">Data:</div>
                    <div class="col-xs-6 col-xs-offset-1 underlined" id="data_entrega">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</div>
                </div>
            </div>
            <!-------------- INFORMA��ES DO CLIENTE -------------->
            <hr style="margin-top: 5px" />
            <p class="text-center tabela lead small">COMPROVANTE DE ENTREGA</p>
            <div class="small" style="margin-top: -15px">
                <div class="row small cliente" style="margin-top: 6px">
                    <div class='col-xs-2'>Cliente:</div>
                    <div class='col-xs-10 underlined'></div>
                </div>
                <!-- DADOS DOS M�VEIS -->
                <div id="produtosEntrega" class="small"></div>
                <!-- CONTRATO DE VENDA -->
                <!-- Dispon�vel para as 2 notas a partir da class contrato -->
                <div class='row small' style='margin-top: 6px'>
                    <div class='col-xs-2'>Data de Venda:</div>
                    <div class='col-xs-2 underlined data_venda'></div>
                    <div class='col-xs-1'>Contrato:</div>
                    <div class='col-xs-1 underlined nota_venda'></div>
                    <div class='col-xs-1'>Fone:</div>
                    <div class='col-xs-2 underlined telefone'></div>
                    <div class='col-xs-1'>Celular:</div>
                    <div class='col-xs-2 underlined celular'></div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-7">VOCÊ FICOU SATISFEITO(A) COM O PRODUTO E O ATENDIMENTO?</div>
                    <div class="col-xs-1">SIM<div class="quadrado" style="margin-left: 25px"></div></div>
                    <div class="col-xs-1">NÃO<div class="quadrado" style="margin-left: 25px"></div></div>
                </div>
                <div class='row small' style='margin-top: 6px'>
                    <div class='col-xs-2'>Observação:</div>
                    <div class='col-xs-10 underlined' style="margin-top: 13px"></div>
                    <div class='col-xs-12 underlined' style="margin-top: 17px"></div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-10">EM CASO DE RECLAMAÇÕES, LIGUE PARA 3245-7474. OBRIGADO</div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-5 underlined"></div>
                    <div class="col-xs-5 col-xs-offset-2 underlined"></div>
                </div>
                <div class="row small" style="margin-top: 0px">
                    <div class="col-xs-5 text-center">Entregador</div>
                    <div class="col-xs-5 col-xs-offset-2 text-center">Assinatura do Cliente</div>
                </div>
            </div>
            <hr class="underlined"/>
        </div>
        <div id='quebra_pagina'></div>
        <!-- MONTAGEM -->
        <div id="montagem" style="margin-top: -15px">
             <!-------------- DADOS DA EMPRESA -------------->
            <div class="row small">
                <!-------------- LOGOMARCA -------------->
                <div class="col-xs-4 .visible-print-inline">
                    <img src="../img/logo_2_reduzida.png" class="img-responsive" alt='logotipo' style="width:110px"/>
                </div>
                <!-------------- FIM DA LOGOMARCA -------------->
                <div class="col-xs-4 tabela small">
                    <h3 class='text-center'>Espaço Conforto</h3>
                    <div class='text-center margemSuperior'>
                        <small>Av. Jerônimo de albuquerque, 304B, Angelim</small>
                    </div>
                    <div class='text-center'>
                        <small>Tel: (98)3245-7474</small>
                        <small>Tel: (98)3259-3445</small>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="col-xs-1">Data:</div>
                    <div class="col-xs-6 col-xs-offset-1 underlined" id="data_montagem">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</div>
                </div>
            </div>
            <!-------------- FIM DOS DADOS DA EMPRESA -------------->
            <hr style="margin-top: 4px" />
            <p class="text-center tabela lead small">COMPROVANTE DE MONTAGEM</p>
            <div class="small" style="margin-top: -15px">
                <div class="row small cliente" style="margin-top: 6px">
                    <div class="col-xs-2">Cliente:</div>
                    <div class="col-xs-10 underlined"></div>
                </div>
                <!-- DADOS DOS M�VEIS -->
                <div class="small">
                    <div id='produtosMontagem'></div>
                    <div class='row' style='margin-top: 6px'>
                        <div class='col-xs-2'>Endereço:</div>
                        <div class='col-xs-10 underlined' id='end_montagem'></div>
                    </div>
                    <div class='row' style='margin-top: 6px'>
                        <div class='col-xs-2'>Pto. Referência:</div>
                        <div class='col-xs-10 underlined' id='ref_montagem'></div>
                    </div>
                </div>
                <!-- CONTRATO DE VENDA -->
                <!-- Dispon�vel para as 2 notas a partir da class contrato -->
                <div class='row small' style='margin-top: 6px'>
                    <div class='col-xs-2'>Data de Venda:</div>
                    <div class='col-xs-2 underlined data_venda'></div>
                    <div class='col-xs-1'>Contrato:</div>
                    <div class='col-xs-1 underlined nota_venda'></div>
                    <div class='col-xs-1'>Fone:</div>
                    <div class='col-xs-2 underlined telefone'></div>
                    <div class='col-xs-1'>Celular:</div>
                    <div class='col-xs-2 underlined celular'></div>
                </div>
                <hr/>
                <div class='row small text-center lead' style="margin-top: -15px">
                    <strong>ATENÇÃO SR. MONTADOR, CONFIRA BEM A MONTAGEM</strong>
                </div>
                <hr style="margin-top: -15px"/>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-2">Montagem:</div>
                    <div class="col-xs-2">Completa<div class="quadrado"></div></div>
                    <div class="col-xs-1">Pendente<div class="quadrado"></div></div>
                </div>
                <hr style="margin-top: 5px"/>
                <div class='row small text-center lead' style="margin-top: -15px">
                    <strong>ATENÇÃO PREZADO(A) CLIENTE</strong>
                </div>
                <hr style="margin-top: -15px"/>
                <div class='row small text-center' style="margin-top: -15px">
                    <strong>ANTES DE ASSINAR, CONFIRA BEM A MONTAGEM DO SEU PRODUTO</strong>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-3">FOI BEM MONTADO?</div>
                    <div class="col-xs-1">SIM<div class="quadrado" style="margin-left: 25px"></div></div>
                    <div class="col-xs-1">NÃO<div class="quadrado" style="margin-left: 25px"></div></div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-5">O MONTADOR PRESTOU UM BOM SERVIÇO?</div>
                    <div class="col-xs-1">SIM<div class="quadrado" style="margin-left: 25px"></div></div>
                    <div class="col-xs-1">NÃO<div class="quadrado" style="margin-left: 25px"></div></div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-7">VOCÊ FICOU SATISFEITO(A) COM O PRODUTO E O ATENDIMENTO?</div>
                    <div class="col-xs-1">SIM<div class="quadrado" style="margin-left: 25px"></div></div>
                    <div class="col-xs-1">NÃO<div class="quadrado" style="margin-left: 25px"></div></div>
                </div>
                <div class='row small' style='margin-top: 6px'>
                    <div class='col-xs-2'>Observação:</div>
                    <div class='col-xs-10 underlined' style="margin-top: 13px"></div>
                    <div class='col-xs-12 underlined' style="margin-top: 17px"></div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-10">EM CASO DE RECLAMAÇÕES, LIGUE PARA 3245-7474. OBRIGADO</div>
                </div>
                <div class="row small" style="margin-top: 15px">
                    <div class="col-xs-5 underlined"></div>
                    <div class="col-xs-5 col-xs-offset-2 underlined"></div>
                </div>
                <div class="row small" style="margin-top: 0px">
                    <div class="col-xs-5 text-center">Montador</div>
                    <div class="col-xs-5 col-xs-offset-2 text-center">Assinatura do Cliente</div>
                </div>
            </div>  
        </div>
    </body>
</html>
