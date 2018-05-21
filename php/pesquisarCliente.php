<?php
include_once '../cls/cliente.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$cliente = new Cliente();

$acao = "";
$nome = "";

if(isset($_POST['acao'])){  //Recebe a a��o a ser cumprida
    $acao = $_POST['acao'];
}

if(isset($_POST['nome'])){    //Recebe o modelo do m�vel
    $nome = utf8_decode($_POST['nome']);
}

header('Content-type: text/xml');

if(strcmp($acao, "obter") == 0){
    $cliente->setNome($nome);
    $resultado = $cliente->obter();    
} elseif(strcmp($acao, "obterAniversariantes")==0){
    $resultado = $cliente->obterAniversariantesDoMes();
} elseif(strcmp($acao, "obterAniversariantesDoDia")==0){
    $resultado = $cliente->obterAniversariantesDoDia();
}


echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    foreach ($resultado as $linha){
        echo "<cliente>";
            echo "<cpfCodificado>";
                echo base64_encode($linha['cpf_cliente']);
            echo "</cpfCodificado>";
            echo "<nome>";
                echo utf8_encode($linha['nome_cliente']);
            echo "</nome>";
            echo "<endereco>";
                echo utf8_encode($linha['endereco']);
            echo "</endereco>";
            echo "<data_nascimento>";
                if(!empty($linha['data_nasc_cliente'])){
                    echo date("d/m/Y", strtotime($linha['data_nasc_cliente']));
                }
            echo "</data_nascimento>";
            echo "<bairro>";
                if(!empty($linha['bairro']) || strcmp($linha['bairro'], " ")==0){
                    echo utf8_encode($linha['bairro']);
                } else {
                    echo " ";
                }
            echo "</bairro>";
            echo "<email>";
            if(!empty($linha['email_cliente'])){
                echo $linha['email_cliente'];
            } else {
                echo " ";
            }
            echo "</email>";
            echo "<telefone>";
                if(empty($linha['tel_cliente']) || strcmp($linha['tel_cliente'], " ")==0){
                    echo "S/N";
                }else {
                    echo $linha['tel_cliente'];
                }
            echo "</telefone>";
            echo "<celular1>";
                if(empty($linha['cel1_cliente']) || strcmp($linha['cel1_cliente'], " ")==0){
                    echo "S/N";
                }else {
                    echo $linha['cel1_cliente'];
                }
            echo "</celular1>";
            echo "<celular2>";
                if(empty($linha['cel2_cliente']) || strcmp($linha['cel2_cliente'], " ")==0){
                    echo "S/N";
                }else {
                    echo $linha['cel2_cliente'];
                }
            echo "</celular2>";
        echo "</cliente>";
    }
    echo "</informacao>";
