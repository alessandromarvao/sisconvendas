<?php
include_once '../cls/fabricante.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$acao = "";
$id = 0;
$nome = "";
$cel = "";
$contato = "";
$rep = "";
$cel1_rep = "";
$cel2_rep = "";

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
}

if(isset($_POST['nome'])){
    $nome = utf8_decode($_POST['nome']);
}

if(isset($_POST['tel'])){
    $tel = $_POST['tel'];
}

if(isset($_POST['cel'])){
    $cel = $_POST['cel'];
}

if(isset($_POST['contato']))
    $contato = utf8_decode($_POST['contato']);

if(isset($_POST['rep']))
    $rep = utf8_decode($_POST['rep']);

if(isset($_POST['cel1_rep']))
    $cel1_rep= $_POST['cel1_rep'];

if(isset($_POST['cel2_rep']))
    $cel2_rep= $_POST['cel2_rep'];

$fabricante = new Fabricante();

$msg = "N�o obteve registros";

if(strcmp($acao, "salvar")==0){
    if($fabricante->salvar($id, $nome, $contato, $tel, $cel, $rep, $cel1_rep, $cel2_rep)){
        $msg =  "Cadastro realizado com sucesso.";
    } else {
        $msg = "Falha ao realizar cadastro.";
    }
} elseif(strcmp($acao, "excluir")==0) {
    if(!empty($_POST['id'])){
        $fabricante->setId($_POST['id']);
        if($fabricante->remover($id)){
            $msg = "ok";
        } else {
           $msg = "N�o foi poss�vel excluir este fornecedor. Verifique se n�o h� mais m�veis comprados por este.";
        }
    } else {
        $msg = "Fornecedor n�o encontrado.";
    }
}

echo utf8_encode($msg);