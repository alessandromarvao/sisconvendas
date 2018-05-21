<?php
include_once '../cls/senha_padrao.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$msg = "";
$senha = "";
$acao = "";
$id = 0;

if(isset($_POST['txtPwd'])){
    $senha = utf8_decode($_POST['txtPwd']);
}

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

$padrao = new Senha_padrao();

if(strcmp($acao, "salvar")==0){
    if(!empty($padrao->obter()['id_padrao'])){
        $id = $padrao->obter()['id_padrao'];
    }
    if(!empty($senha) && $padrao->salvar($id, $senha)){
       $msg = "Cadastro realizado com sucesso.\n";
    } else {
        $msg = "Falha ao realizar cadastro.\n";
    }
} elseif(strcmp($acao, "carregar")==0) {
    $msg = $padrao->obter()['padrao_decod'];
}

echo $msg;