<?php
include_once '../cls/compra.class.php';
include_once '../cls/movel.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$acao = "";
$id = 0;
$qtde = 0;
$valor = 0.0;

if(!empty($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(!empty($_POST['idMovel'])){
    $id = $_POST['idMovel'];
}

if(!empty($_POST['qtde'])){
    $qtde = $_POST['qtde'];
}

if(!empty($_POST['valor'])){
    $valor = $_POST['valor'];
}

$movel = new Movel($id);
$compra = new compra();

if(strcmp($acao, "carregarPagina")==0){
    header('Content-type: text/xml');
    
    $resultado = $movel->obter();
    $compra->setMovel($id);
    $resCompra = $compra->obterUltimaCompraProduto();
    
    echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
    echo "<informacao>";
        echo "<vazio>";
            if(count($resultado)<6){
                echo "s";
            } else {
                echo "n";
            }
        echo "</vazio>";
        echo "<movel>";
            echo "<modelo>";
                echo utf8_encode($resultado['modelo']);
            echo "</modelo>";
            echo "<marca>";
                echo utf8_encode($resultado['empresa']);
            echo "</marca>";
            echo "<valor>";
            if(!empty($resCompra['valor_bruto'])){
                $valor = (double)$resCompra['valor_bruto'];
                echo number_format($valor, 2, ",", "");
            } else {
                echo "00,00";
            }
            echo "</valor>";
            echo "<imagem>";
            if(!empty($resultado['movel_img'])){
                echo utf8_encode($resultado['movel_img']);
            } else {
                echo utf8_encode("../img/empty.gif");
            }
            echo "</imagem>";
        echo "</movel>";
    echo "</informacao>";
} elseif(strcmp($acao, "salvar")==0) {

    if($compra->salvar(0, $id, $valor, $qtde) && $movel->adicionarEstoque($id, $qtde)){
        echo "ok";
    } else {
        echo "Você já cadastrou esta compra hoje.";
    }
}