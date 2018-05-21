<?php
include_once 'cls/sessao.class.php';;

$sessao = new Sessao();

//Confere se o usuário está cadastrado no Sistema e sua situação está ativa.
if($sessao->validaLogin()==2 && (strcmp($sessao->getSituacao(), 'ativo')==0)){
    $funcao = $sessao->getFuncao();
    if($sessao->getBloquearUsuario() == FALSE){
        if(strcmp($funcao, 'admin')==0){    //encaminha o usuário para a página de administrativo.
            header("location: admin/index.php");
        } else {    //encaminha para a página de vendedor.
            header("location: vendedor/index.php");
        }
    } else {
        header("location: bloqueado.php");
    }
} else { //encerra a sess�o.
    $sessao->destroy();
    header("location: index.php");
}