<?php
include_once '../cls/movel.class.php';

$id = 1;
$acao = "";

if(!empty($_POST['id'])){
    $id = base64_decode($_POST['id']);
}

if(!empty($_POST['acao'])){
    $acao = $_POST['acao'];
}

$movel = new Movel($id);

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";

if(strcmp($acao, "obterUnidade")==0){
    $resultado = $movel->obter();

    echo "<movel>";
        echo "<id_movel>";
            echo $resultado['id_movel'];
        echo "</id_movel>";
        echo "<img>";
            if(!empty($resultado['movel_img'])){
                echo $resultado['movel_img'];
            } else {
                echo " ";
            }
        echo "</img>";
        echo "<id_fornecedor>";
            echo $resultado['id_fabricante'];
        echo "</id_fornecedor>";
        echo "<tipo>";
            echo $resultado['tipo'];
        echo "</tipo>";
        echo "<modelo>";
            echo $resultado['modelo'];
        echo "</modelo>";
        echo "<estoque>";
            echo $resultado['estoque'];
        echo "</estoque>";
        echo "<valor>";
            echo number_format($resultado['valor_venda'], 2, ",", "");
        echo "</valor>";
    echo "</movel>";
} elseif(strcmp($acao, "carregarTipos")==0){
    $resultado = $movel->obterTipos();
    echo "<tipos>";
    foreach ($resultado as $linha){
        echo "<tipo>";
            echo $linha['tipo'];
        echo "</tipo>";
    }
    echo "</tipos>";
}