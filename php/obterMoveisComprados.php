<?php
include_once '../cls/compra.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$data1 = "";
$data2 = "";
$fornecedor = "";
$movel = "";
$resultado = "";

$movelDAO = new Compra();

if(isset($_POST['data1']) && isset($_POST['data2'])){
    $data1 = utf8_decode($_POST['data1']);
    $data2 = utf8_decode($_POST['data2']);
    
    $resultado = $movelDAO->obterPorIntervaloDeDatas($data1, $data2);
}

if(isset($_POST['empresa'])){
    $fornecedor = utf8_decode($_POST['empresa']);
    $movelDAO->setEmpresa($fornecedor);
    
    $resultado = $movelDAO->obter();
}

if(isset($_POST['movel'])){
    $movel = utf8_decode($_POST['movel']);
    
    $resultado = $movelDAO->obterPorMoveis($movel);
}

//Exibir todos
if(isset($_POST['acao']) && strcmp($_POST['acao'], "todos")==0){
    $resultado = $movelDAO->obter();
}

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
echo "<compras>";
foreach ($resultado as $linha){
    echo "<compra>";
        echo "<data>";
            echo date('d/m/Y', strtotime($linha['data_compra']));
        echo "</data>";
        echo "<valor>";
            echo $linha['valor_bruto'];
        echo "</valor>";
        echo "<qtde>";
            echo $linha['qtde_compra'];
        echo "</qtde>";
        echo "<modelo>";
            echo $linha['modelo'] . " " . $linha['empresa'];
        echo "</modelo>";
        echo "<fornecedor>";
            echo $linha['empresa'];
        echo "</fornecedor>";
    echo "</compra>";
}
echo "</compras>";