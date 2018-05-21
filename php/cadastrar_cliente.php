<?php
include_once '../cls/cliente.class.php';
$cpf = "";
$nome = "";
$email = "";
$dataNascimento = "";
$end = "";
$bairro = "";
$ref = "";
$cep = "";
$tel = "";
$cel1 = "";
$cel2 = "";


if(isset($_POST['txtCPF'])){
    $cpf = $_POST['txtCPF'];
}

if(isset($_POST['txtNome'])){
    $nome = utf8_decode($_POST['txtNome']);
}
if(isset($_POST['txtEmail'])){
    $email = $_POST['txtEmail'];
}
if(isset($_POST['txtDataNascimento'])){
    $array = explode("/", $_POST['txtDataNascimento']);
    $dataNascimento = implode("-", array_reverse($array));
}
if(isset($_POST['txtEnd'])){
    $end = utf8_decode($_POST['txtEnd']);
}
if(isset($_POST['txtBairro'])){
    $bairro = utf8_decode($_POST['txtBairro']);
}
if(isset($_POST['txtReferencia'])){
    $ref = utf8_decode($_POST['txtReferencia']);
}
if(isset($_POST['txtCEP'])){
    $cep = $_POST['txtCEP'];
}
if(isset($_POST['txtTelefone'])){
    $tel = $_POST['txtTelefone'];
}
if(isset($_POST['txtCel1'])){
    $cel1 = $_POST['txtCel1'];
}
if(isset($_POST['txtCel2'])){
    $cel2 = $_POST['txtCel2'];
}

$cliente = new Cliente($cpf);

if(empty($cliente->obter())){
    if($cliente->salvar($cpf, $nome, $dataNascimento, $email, $end, $bairro, $ref, $cep, $tel, $cel1, $cel2)){
        echo utf8_encode("Cadastro realizado com sucesso.");
    } else {
        echo utf8_encode("Falha ao realizar cadastro.");
    }
} else {
    if($cliente->alterar($cpf, $nome, $dataNascimento, $email, $end, $bairro, $ref, $cep, $tel, $cel1, $cel2)){
        echo utf8_encode("Alteração realizada com sucesso.");
    } else {
        echo utf8_encode("Falha ao alterar cadastro.");
    }
}
