<?php
include_once '../cls/carrinho_compras.class.php';
include_once '../cls/cliente.class.php';
include_once '../cls/sessao.class.php';

/* 
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */

$sessao = new Sessao();
$carrinho = new Carrinho_compras();
$cpfCliente = $sessao->getCliente();
$carrinho->setCliente($cpfCliente);
$resultado = $carrinho->obter();
$txtCliente = "";

if(!empty($cpfCliente) && count($resultado)!==0){
    $cpf = base64_encode($cpfCliente);
    $link = "pesquisar_movel.php?id=" . $cpf;
    
    $cliente = new Cliente($cpfCliente);
    $resCliente = $cliente->obter();
    
    if(isset($resCliente['nome_cliente'])){
        $nome = utf8_encode($resCliente['nome_cliente']);
    }
    
    if(isset($resCliente['endereco'])){
        $end = utf8_encode($resCliente['endereco']);
    }
    
    if(isset($resCliente['pto_referencia'])){
        $ref = utf8_encode($resCliente['pto_referencia']);
    }
    
    if(isset($resCliente['bairro'])){
        $bairro = utf8_encode($resCliente['bairro']);
    }
    
    $tel = "S/N";
    $cel1 = "S/N";
    $cel2 = "S/N";
    
    if(isset($resCliente['tel_cliente'])) {
        $tel = $resCliente['tel_cliente'];
    }
    
    if(isset($resCliente['cel1_cliente'])){
        $cel1 = $resCliente['cel1_cliente'];
    }
    
    if(isset($resCliente['cel2_cliente'])){
        $cel2 = $resCliente['cel2_cliente'];
    }
    
} elseif(empty($resultado)) {
    header("location: pesquisar_cliente.php");
} else {
    header("location: pesquisar_cliente.php");
}

if($sessao->situacaoOK()==FALSE){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/logoff.php");
}

?>

<html>
    <head>
        <meta charset="Windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
        
        <script src="../js/ajax.js" > </script>
        <script src="js/carrinho.js" ></script>
        
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
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-12 spacing">
                            <div class="hidden">
                                <?php
                                echo "<input type='text' value='" . $cpfCliente . "' id='cpf' />";
                                if($sessao->issetSessao("endereco")){ //Armazena o endere�o a ser entregue o m�vel.
                                    echo "<input typq='text' value='" . utf8_encode($sessao->getEndereco()) . "' id='enderecoEntrega' />";
                                } else {    
                                    echo "<input typq='text' value='" . $end . "' id='enderecoEntrega' />";
                                }
                                if($sessao->issetSessao("referencia")){
                                    echo "<input typq='text' value='" . $sessao->getReferencia() . "' id='refEntrega' />";
                                } else {    
                                    echo "<input typq='text' value='" . $ref . "' id='refEntrega' />";
                                }
                                ?>
                            </div>
                            <label>INFORMAÇÕES DO CLIENTE</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Cliente</td>
                                        <td>Endereço</td>
                                        <td>Referência</td>
                                        <td>Fone</td>
                                        <td>Celular</td>
                                        <td>Celular</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $nome; ?></td>
                                        <td>
                                        <?php 
                                        if(!$sessao->issetSessao('endereco')){
                                            echo $end . ", " . $bairro ;
                                        } else {
                                            echo utf8_encode($sessao->getEndereco());
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <?php 
                                        if(!$sessao->issetSessao('referencia')){
                                            echo $ref;
                                        } else {
                                            echo $sessao->getReferencia();
                                        }
                                        ?>
                                        </td>
                                        <td><?php echo $tel; ?></td>
                                        <td><?php echo $cel1; ?></td>
                                        <td><?php echo $cel2; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 spacing">
                        <label>DISCRIMINAÇÃO DAS MERCADORIAS</label>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td>Descrição</td>
                                        <td>Qtde</td>
                                        <td>Valor unitário</td>
                                        <td>total</td>
                                        <td>Entrega</td>
                                        <td>Montagem</td>
                                        <td>Excluir</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($resultado)){
                                        $i = 0;
                                        $valorTotal = 0;
                                        foreach ($resultado as $linha){
                                            $i++;
                                            $qtde = (int) $linha['qtde_carrinho'];
                                            $valorUnid = (double) $linha['valor_unidade'];
                                            $calc = $qtde * $valorUnid;
                                            $total = number_format($calc, 2, ".", "");
                                            $entrega = "";
                                            $montagem = "";
                                            if($linha['entrega']==0){
                                                $entrega = "N";
                                            } else {
                                                $entrega = "S";
                                            }
                                            
                                            if($linha['montagem']==0){
                                                $montagem = "N";
                                            } else {
                                                $montagem = "S";
                                            }
                                            
                                            echo "<tr>\n";
                                                echo "<td>";
                                                    echo utf8_encode($linha['modelo']);
                                                echo "</td>\n";
                                                echo "<td>";
                                                    echo $qtde;
                                                echo "</td>\n";
                                                echo "<td>";
                                                    echo number_format($valorUnid, 2, ",", "");
                                                echo "</td>\n";
                                                echo "<td>";
                                                    echo number_format($total, 2, ",", "");
                                                echo "</td>\n";
                                                echo "<td class='text-center'>";
                                                    echo $entrega;
                                                echo "</td>\n";
                                                echo "<td class='text-center'>";
                                                    echo $montagem;
                                                echo "</td>\n";
                                                echo "<td>";
                                                    echo "<a href='#' onclick='excluirDoCarrinho(\"" . $linha['id_movel_FK'] . "\")'>Excluir</a>";
//                                                    echo "<input type='checkbox' class='checkbox' id='chkbx' onclick='excluirDoCarrinho(\"" . $linha['id_movel_FK'] . "\")' />";
                                                echo "</td>\n";
                                                $valorTotal += $total;
                                            echo "</tr>\n";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        echo "<input type='text' class='hidden' id='total' value='" . number_format($valorTotal, 2, ",", "") . "' />";
                        ?>
                        <div class="col-sm-6 col-sm-offset-6 spacing">
                            <label>Desconto (R$):</label>
                            <input type="text" class="form-control" id="desconto" onkeyup="calcularTotal()" />
                            <label>Valor Total (R$):</label>
                            <?php
                            echo "<input type='text' class='form-control' value='" . number_format($valorTotal, 2, ",", "") . "' id='valorTotal' readonly />";
                            ?>
                            <br />
                        </div>
                        <div class=" col-sm-4 spacing">
                            <button type="button" class="btn btn-lg btn-block btn-success hidden-print" onclick="salvar()">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Confirmar
                            </button>
<!--                            <input type="button" class="btn btn-lg btn-block btn-success hidden-print" value="Confirmar" onclick="salvar()">-->
                        </div>
                        <div class=" col-sm-4 spacing">
                            <?php 
                            echo "<a href='" . $link . "' class='btn btn-lg btn-block btn-default hidden-print'><span class='glyphicon glyphicon-circle-arrow-left'></span> Adicionar móvel</a>";
                            ?>
                        </div>
                        <div class=" col-sm-4 spacing">
                            <a href="../php/cancelar_carrinho.php" class="btn btn-lg btn-block btn-warning hidden-print">
                                <span class="glyphicon glyphicon-remove"></span> Cancelar Compra</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm ">
                    <img src="../img/img_25_1080x1920.jpg" alt="Espaço Conforto." style="height: 100%" />
                </div>
            </div>
        </div>
    </body>
</html>