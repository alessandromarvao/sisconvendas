<?php
include_once '../cls/movel.class.php';
include_once '../cls/sessao.class.php';

$sessao = new Sessao();

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/redirecionar.php");
}

$imagem = "<img src='../img/empty.gif' title='Sem imagem para exibir' class='img-responsive hidden-sm hidden-xs' />";

$id = "";
if(isset($_REQUEST['id'])){
    $id = base64_decode($_REQUEST['id']);
}

//if(!empty($id)){
//    $mov = new Movel($id);
//    $resultado = $mov->obter();
//    $preco = "<input type='text' name='txtValor' class='form-control' placeholder='Digite aqui o valor que o m�vel ser� vendido ao cliente' />";
//    $nome = "<input type='text' name='txtModelo' class='form-control' />";
//    $id = "<input type='text' name='txtId' class='form-control' readonly />";
//    if(!empty($resultado['id_movel'])){
//        if($resultado['movel_img']){
//            $imagem =  "<img src='" . $resultado['movel_img'] . "' class='img-responsive hidden-sm hidden-xs' style='width: 50%' />";
//        } else {    
//            $imagem =  "<img src='../img/empty.gif' class='img-responsive hidden-sm hidden-xs' style='width: 50%' />";
//        }
//        $preco = "<input type='text' name='txtValor' class='form-control' placeholder='Digite aqui o valor que o m�vel ser� vendido ao cliente' value='" . number_format($resultado['valor_venda'], 2, ",", "") . "' />";
//        $nome = "<input type='text' value='" . $resultado['modelo'] . "' name='txtModelo' class='form-control' />";
//        $id = "<input type='text' value='" . $resultado['id_movel'] . "' id='cod_movel' name='txtId' class='form-control' readonly />";
//    }
//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/alterar_movel.js"></script>
    
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
<body class="bg_herdado" onload="carregar()">
    <div class="container content">
        <div class="row">
            <div class="form-group col-md-8 col-lg-6">
                <div id="titulo"></div>
                <form role="form" action="../php/cadastrar_movel.php" method="POST" enctype='multipart/form-data'>
                    <div id="img_movel" />
                    <img src='../img/empty.gif' id='img' class='img-responsive hidden-sm hidden-xs' style='width: 50%' />
                    <br/>
                    <input type="text" id="cod_movel" name="txtId" class="hidden" />
                    <br/>
                    <label>Deseja alterar a imagem do móvel? (opcional)</label>
                    <input type='file' name='imgMovel' class="form-control" />
                    <br />
                    <label>Fornecedor (CUIDADO AO ALTERAR)</label>
                    <select id="fornecedores" class="form-control" name="txtFabricante" ></select>
                    <br />
                    <label>Tipo (VERIFIQUE COM ATENÇÃO)</label>
                    <select id="tipos" class="form-control" name="txtTipo" required></select>
                    <br />
                    <label>Modelo</label>
                    <input type='text' id="modelo" name='txtModelo' class='form-control' />
                    <br />
                    <label>Estoque</label>
                    <input type='text' id="estoque" class='form-control' name='txtEstoque' placeholder="Digite aqui a quantidade no estoque" autocomplete="off" />
                    <br />
                    <label>Preço Final</label>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <input type='text' id="valor" name='txtValor' class='form-control' placeholder='Digite aqui o valor que o móvel será vendido ao cliente' autocomplete="off" />
                    </div>
                    <br />
                    <br/>
                    <div class="row">
                        <div class='col-md-4 col-sm-4 spacing'>
                            <button type="submit" class="btn btn-lg btn-block btn-success" value="Confirmar" title="Confirma o cadastro. Você será encaminhado à página de confirmação">
                                <span class="glyphicon glyphicon-floppy-save"></span> Confirmar
                            </button>
                        </div>
                        <div class='col-md-4 col-sm-4 spacing'>
                            <a href="index.php" class="btn btn-lg btn-block btn-warning" title="Cancela o cadastro e volta à pagina ininical">
                                <span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-lg-4 col-lg-offset-1 hidden-xs hidden-sm">
                <img src="../img/img_5_1080x1920.jpg" style="width: 30%; position: fixed" />
            </div>
        </div>
    </div>
</body>
</html>
