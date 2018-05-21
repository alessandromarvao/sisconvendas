<?php
include_once '../cls/movel.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$movel = new Movel();

$acao = "obter";
$modelo = "";

if(isset($_POST['acao'])){  //Recebe a a��o a ser cumprida
    $acao = $_POST['acao'];
}

if(isset($_POST['modelo'])){    //Recebe o modelo do m�vel
    $modelo = $_POST['modelo'];
}


//Obtem por modelo(Todos), por estoque e com estoque baixo
$movel->setModelo($modelo);

if(strcmp($acao, "obter")==0){ //Obter por modelo
    $movel->setModelo($modelo);
    $resultado = $movel->obter();
} elseif (strcmp($acao, "obterLimite")==0) { //Obter m�veis com estoque baixo. (Necess�rio)
    $resultado = $movel->obterEstoqueBaixo();
}

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
echo "<informacao>";
foreach ($resultado as $linha){
    //Codifica o id do m�vel.
    $idCodificado = base64_encode($linha['id_movel']);


    //Calcula o valor e retorna ao padr�o brasileiro BR$.
    if(isset($linha['valor_venda'])){
        $valor = $linha['valor_venda'];
    } else {
        $valor = 0;
    }
    $valorVenda = number_format($valor, 2, ",", "");

    //�rvore XML
    echo "<movel>";
        echo "<modelo>";
            echo utf8_encode($linha['modelo']);
        echo "</modelo>";
        echo "<fornecedor>";
            echo utf8_encode($linha['empresa']);
        echo "</fornecedor>";
        echo "<codigo>";
            echo $linha['id_movel'];
        echo "</codigo>";
        echo "<valor_venda>";
            echo $valorVenda; //Ver linha 48
        echo "</valor_venda>";
        echo "<codigoB64>";
            echo $idCodificado;
        echo "</codigoB64>";
        echo "<qtde>";
        if(empty($linha['estoque'])){
            echo "0";
        } else{
            echo $linha['estoque'];
        }
        echo "</qtde>";
        echo "<tipo>";
            echo utf8_encode($linha['tipo']);
        echo "</tipo>";
    echo "</movel>";
}
echo "</informacao>";