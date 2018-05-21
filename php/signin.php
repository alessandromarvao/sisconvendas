<?php
include_once '../cls/autenticacaoDAO.class.php';
include_once '../cls/senha_padrao.class.php';
include_once '../cls/sessao.class.php';
include_once '../cls/tentativasDAO.class.php';
include_once '../cls/usuario.class.php';

$sessao = new Sessao();

if(!$sessao->situacaoOK()){
//    header("location: ../php/logoff.php");
}

$usr = "";
$pwd = "";

if(isset($_POST['usr'])){
    $usr = $_POST['usr'];
}

if(isset($_POST['pwd'])){
    $pwd = $_POST['pwd'];
}

$autenticacao = new AutenticacaoDAO();
$padrao = new Senha_padrao();

$valida = $autenticacao->confereAutenticacao($usr, $pwd);

$resultado = $autenticacao->obterAutenticacao($usr);

$usuario = new Usuario($usr);
$info_usr = $usuario->obter($usr);

if($autenticacao->isSenhaExpirada($usr)){
    header("location: senha_expirada.php");
}elseif(strcmp($valida, "OK")==0){    //Usuário logado com sucesso.
    $sessao->setStatus('ok');
    $sessao->setLogin($usr);
    $sessao->setNome($info_usr['nome']);
    $sessao->setFuncao($info_usr['funcao']);
    $sessao->setSituacao($info_usr['situacao']);
    $sessao->setBloquearUsuario($resultado['bloquear']);
    
    if(strcmp($resultado['pwd'], $padrao->obter()['padrao'])!==0){ //Confere se a senha é igual à senha padrão.
        if(strcmp($info_usr['funcao'], 'administrador')==0){
            header("location: ../admin/index.php");
        } elseif(strcmp($info_usr['funcao'], 'vendedor(a)')==0){
            header("location: ../vendedor/index.php");
        }
    } else {
        header("location: alterar_senha.php?id=" . base64_encode($usr));
    }
    
    
} elseif(strcmp($valida, "PWD_FAIL")==0){    //Senha incorreta.
    $sessao->setStatus('no_pwd');
    $tentativas = new TentativasDAO();
    $tentativas->salvar($usr);
    
    if($tentativas->obterTentativasDoDia($usr, date("Y-m-d"))>=5){ //Confere a quantidade de tentativas de conexão que falharam.
        $autenticacao->bloquear($usr);
        header("location: ../index.php");
    } else {
        header("location: ../index.php");
    }
    
} else {    //Usuário inexistente.
    $sessao->setStatus("no_user");
    header("location: ../index.php");
}