<?php
include_once '../cls/movel.class.php';
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
//Confere se a autentica��o foi validada.
if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/logoff.php");
}

$id = "";
$nome = "";

if(isset($_REQUEST['id'])){
    $id = base64_decode($_REQUEST['id']);
}

if(!empty($id)){
    $mov = new Movel($id);
    $resultado = $mov->obter();
    $imagem =  "<img src='" . $resultado['movel_img'] . "' style='width: 100%' />";
    if($sessao->issetSessao("cliente")){
        $cliente = "<input type='text' id='cpf' value='" . $sessao->getCliente() . "' class=hidden />";
    }
    $id = "<input type='text' value='" . $resultado['id_movel'] . "' name='txtId' id='id' class='form-control' readonly />\n";
    $nome = utf8_encode("<input type='text' value='" . $resultado['modelo'] . "' name='txtModelo' class='form-control' readonly />\n");
    $valorVenda = $resultado['valor_venda'];
    //limita a quantidade m�xima de m�veis a ser comprado de acordo com a quantidade no estoque
    $qtde =  $resultado['estoque'];
    $campoLimiteQtde = "<input type='text' class='hidden' id='qtde_limite' value='$qtde' ?>\n";
    $valor = "<input type='text' name='txtValor' value='" . number_format($valorVenda, 2, ",", "") . "' name='txtValor' class='form-control' id='valor' readonly required />\n";
} else {
    header("location: pesquisar_cliente.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/somar_valor.js"></script>
    
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
<body onload='carregarTotal()' class="bg_herdado">
    <form role="form" method="POST">
        <div class="container content">
            <div class="row">
                <h2>Selecionar Móvel</h2>
                <div class="col-sm-4 col-md-3 hidden-xs">
                    <img src="../img/empty.gif" id="img" class="img-responsive hidden-sm hidden-xs" >
                    <?php 
                    echo $imagem;
                    ?>
                </div>
                <?php
                echo $campoLimiteQtde;
                ?>
                <div class="col-xs-12 col-sm-8 col-md-6">
                    <label class="spacing">Código do Móvel Selecionado</label>
                    <?php
                    echo $id;
                    echo $cliente;
                    ?>
                    <label class="spacing">Modelo:</label>
                    <?php
                    echo $nome;
                    ?>
                    <label class="spacing">Quantidade comprada:</label>
                    <input type="number" min="1" <?php echo "max='" . $qtde . "'"; ?> step="1" class="form-control" value="1" id="qtde"  placeholder="Digite aqui a quantidade do móvel comprada" onkeyup="enviaDados('somar', 'qtde', 'valor')"  onclick="enviaDados('somar', 'qtde', 'valor')" autofocus />
                    <label class="spacing">Valor unitário:</label>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <?php
                        echo $valor;
                        ?>
                    </div>
                    <label class="spacing">Total:</label>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <input type="text" id='total' class="form-control" readonly />
                    </div>
                    <br/>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="0" id='entrega' onclick="alterarValor('entrega')" />Entrega a domicílio
                        </label>
                        <br/>
                        <div id="campo_entrega" class="col-lg-12"></div>
                        <label>
                            <input type="checkbox" value="0" id='montagem' onclick="alterarValor('montagem')" />Requer montagem
                        </label>
                        <br/>
                        <div id="campo_montagem"></div>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-offset-3 col-md-3 spacing hidden-xs hidden-sm">
                    <button type="button" class="btn btn-lg btn-success btn-block" onclick="salvar()">
                        <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;&nbsp;Comprar
                    </button>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 spacing">
                    <a href="../php/cancelar_carrinho.php" class="btn btn-lg btn-warning btn-block" title="Cancela o registro da compra e volta à página inicial" >
                        <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
