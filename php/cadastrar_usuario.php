<?php
include_once '../cls/autenticacaoDAO.class.php';
include_once '../cls/usuario.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$login = "";
$nome = "";
$cpf = "";
$funcao = "";
$email = "";
$nascimento = "";
$tel = "";
$cel1 = "";
$cel2 = "";

$usr = new Usuario();
$aut = new AutenticacaoDAO();

if(isset($_POST['txtLogin'])){
    $login = utf8_decode($_POST['txtLogin']);
}

if(isset($_POST['txtNome'])){
    $nome = utf8_decode($_POST['txtNome']);
}

if(isset($_POST['txtCPF'])){
    $cpf = utf8_decode($_POST['txtCPF']);
}

if(isset($_POST['txtFuncao'])){
    $funcao = utf8_decode($_POST['txtFuncao']);
}

if(isset($_POST['txtEmail'])){
    $email = utf8_decode($_POST['txtEmail']);
}

if(isset($_POST['txtNascimento'])){
    $array = explode("/", $_POST['txtNascimento']);
    $nascimento = implode("-", array_reverse($array));
}

if(isset($_POST['txtTel'])){
    $tel = utf8_decode($_POST['txtTel']);
}

if(isset($_POST['txtCel1'])){
    $cel1 = utf8_decode($_POST['txtCel1']);
}

if(isset($_POST['txtCel2'])){
    $cel2 = utf8_decode($_POST['txtCel2']);
}

$dadosAut = $aut->obterAutenticacao($login);

if(!empty($dadosAut)){  //existe na tabela autentica��o, provavelmente existe em usu�rio, serve para alterar
    if($usr->salvar($login, $nome, $funcao, $cpf, $email, $tel, $cel1, $cel2, $nascimento)){
        echo utf8_encode("Opera��o realizada com sucesso.\n");
    } else {
        echo utf8_encode("Falha na opera��o de altera��o.\n");
    }
} else {    //salva na tabela autentica��o e usu�rio.
    if($aut->salvar($login) && $usr->salvar($login, $nome, $funcao, $cpf, $email, $tel, $cel1, $cel2, $nascimento)){
        echo utf8_encode("Opera��o realizada com sucesso.\n");
    } else {
        echo utf8_encode("\nFalha na opera��o de inser��o. \nVerifique se a senha padr�o j� fora cadastrada. \n");
    }
}
?>