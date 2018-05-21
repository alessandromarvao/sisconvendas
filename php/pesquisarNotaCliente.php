<?php
include_once '../cls/vendaDAO.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$venda = new VendaDAO();
$cliente = "";

if(!empty($_POST['nome'])){
    $cliente = $_POST['nome'];
}

$resultado = $venda->obterUltimasNotasDeVendasPorClientes($cliente);


header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";

echo "<resultado>";
foreach ($resultado as $linha) {
    echo "<cliente>";
        echo "<notaCodificada>";
            echo base64_encode($linha['nota']);
        echo "</notaCodificada>";
        echo "<nome>";
            echo utf8_encode($linha['nome']);
        echo "</nome>";
        echo "<cpf>";
            echo $linha['cpf'];
        echo "</cpf>";
        echo "<nota>";
            echo $linha['nota'];
        echo "</nota>";
        echo "<data>";
            echo date("d/m/Y", strtotime($linha['data']));
        echo "</data>";
    echo "</cliente>";
}
echo "</resultado>";