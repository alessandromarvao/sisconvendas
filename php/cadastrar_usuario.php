<?php
include_once '../cls/autenticacaoDAO.class.php';
include_once '../cls/usuario.class.php';

// Garante que o navegador do usuбrio nгo realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da ъltima modificaзгo da pбgina
header('Cache-Control: no-cache, must-revalidade'); // Nгo vai ser armazenada em cache
header('Pragma: no-cache'); // Nгo vai ser armazenada em cache

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

if(!empty($dadosAut)){  //existe na tabela autenticaзгo, provavelmente existe em usuбrio, serve para alterar
    if($usr->salvar($login, $nome, $funcao, $cpf, $email, $tel, $cel1, $cel2, $nascimento)){
        echo utf8_encode("Operaзгo realizada com sucesso.\n");
    } else {
        echo utf8_encode("Falha na operaзгo de alteraзгo.\n");
    }
} else {    //salva na tabela autenticaзгo e usuбrio.
    if($aut->salvar($login) && $usr->salvar($login, $nome, $funcao, $cpf, $email, $tel, $cel1, $cel2, $nascimento)){
        echo utf8_encode("Operaзгo realizada com sucesso.\n");
    } else {
        echo utf8_encode("\nFalha na operaзгo de inserзгo. \nVerifique se a senha padrгo jб fora cadastrada. \n");
    }
}
?>