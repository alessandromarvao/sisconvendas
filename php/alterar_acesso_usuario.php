<?php
include_once '../cls/autenticacaoDAO.class.php';
include_once '../cls/usuario.class.php';

//$sessao = new Sessao();
//
//if(!$sessao->situacaoOK()){
//    header("location: ../php/logoff.php");
//}
//
//if(strcmp($sessao->getFuncao(), 'administrador')!==0){
//    header("location: ../php/logoff.php");
//}

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

if(isset($_POST['txtLogin']) && isset($_POST['txtNome']) && isset($_POST['opcao'])){
    $id = utf8_decode($_POST['txtLogin']);
    $nome = utf8_decode($_POST['txtNome']);
    $sel = utf8_decode($_POST['opcao']);

    $aut = new autenticacaoDAO();
    $usr = new Usuario();

    if($sel==1){
        if($aut->desbloquear($id)){
            echo utf8_encode($nome . " desbloqueado com sucesso.");
        } else {
            echo utf8_encode("Falha ao desbloquear " . $nome . ".");
        }
    } elseif($sel==2) {
        if($usr->bloquearAcesso($id, TRUE)){
            echo utf8_encode($nome . " bloqueado no Sistema.");
        } else {
            echo utf8_encode("Não é possível bloquear " . $nome . ".");
        }
    } else {
        if($usr->bloquearAcesso($id, FALSE)){
            echo utf8_encode($nome . " desbloqueado no Sistema.");
        } else {
            echo utf8_encode("Não foi possível liberar acesso para " . $nome . ".");
        }
    }
} else {
    echo utf8_encode("Você não pode realizar esta operação!");
}
