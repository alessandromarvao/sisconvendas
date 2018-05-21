<?php
include_once '../cls/cliente.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$acao = "";
$cpf = "";

if(isset($_POST['acao']))
    $acao = $_POST['acao'];

if(isset($_POST['cpf']))
    $cpf = $_POST['cpf'];

$cliente = new Cliente($cpf);

header('Content-type: text/xml');

if(strcmp($acao, "obter") == 0){
    $resultado = $cliente->obter();

    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    echo "<cliente>";
        echo "<nome>";
            echo $resultado['nome_cliente'];
        echo "</nome>";
        echo "<cpf>";
            echo $resultado['cpf_cliente'];
        echo "</cpf>";
        echo "<email>";
            if(!empty($resultado['email_cliente'])){
                echo $resultado['email_cliente'];
            } else {
                echo " ";
            }
        echo "</email>";
        echo "<dataNascimento>";
            if(!empty($resultado['data_nasc_cliente'])){
                echo date('d/m/Y', strtotime($resultado['data_nasc_cliente']));
            } else {
                echo " ";
            }
        echo "</dataNascimento>";
        echo "<endereco>";
            if(!empty($resultado['endereco'])){
                echo $resultado['endereco'];
            } else {
                echo " ";
            }
        echo "</endereco>";
        echo "<bairro>";
            echo $resultado['bairro'];
        echo "</bairro>";
        echo "<referencia>";
            if(!empty($resultado['pto_referencia'])){
                echo $resultado['pto_referencia'];
            } else {
                echo " ";
            }
        echo "</referencia>";
        echo "<cep>";
            if(empty($resultado['cep'])){
                echo " ";
            } else {
                echo $resultado['cep'];
            }
        echo "</cep>";
        echo "<telefone>";
            if(empty($resultado['tel_cliente'])){
                echo " ";
            } else {
                echo $resultado['tel_cliente'];
            }
        echo "</telefone>";
        echo "<celular1>";
            if(empty($resultado['cel1_cliente'])){
                echo " ";
            } else {
                echo $resultado['cel1_cliente'];
            }
        echo "</celular1>";
        echo "<celular2>";
            if(empty($resultado['cel2_cliente'])){
                echo " ";
            } else {
                echo $resultado['cel2_cliente'];
            }
        echo "</celular2>";
    echo "</cliente>";
    echo "</informacao>";
}
