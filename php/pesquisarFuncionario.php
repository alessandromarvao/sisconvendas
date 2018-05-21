<?php
include_once '../cls/usuario.class.php';
include_once '../cls/autenticacaoDAO.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$usuario = new Usuario();
$aut = new AutenticacaoDAO();

$acao = "";
$nome = "";

if(isset($_POST['acao'])){  //Recebe a ação a ser cumprida
    $acao = $_POST['acao'];
}

if(isset($_POST['nome'])){    //Recebe o modelo do móvel
    $nome = utf8_decode($_POST['nome']);
}

header('Content-type: text/xml');

if(strcmp($acao, "obter" == 0)){
    $usuario->setNome($nome);
    $resultado = $usuario->obter();

    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    foreach ($resultado as $linha){
        $resAut = $aut->obterAutenticacao($linha['login_FK']);
        $bloquear = "";
        if($resAut['bloquear']==0){
            $bloquear = "não";
        } else {
            $bloquear = "sim";
        }
        echo "<usuario>";
            echo "<loginCodificado>";
                echo base64_encode($linha['login_FK']);
            echo "</loginCodificado>";
            echo "<login>";
                echo $linha['login_FK'];
            echo "</login>";
            echo "<nome>";
                echo $linha['nome'];
            echo "</nome>";
            echo "<funcao>";
                echo $linha['funcao'];
            echo "</funcao>";
            echo "<situacao>";
                echo $linha['situacao'];
            echo "</situacao>";
            echo "<senha_bloqueada>";
                echo $bloquear;
            echo "</senha_bloqueada>";
        echo "</usuario>";
    }
    echo "</informacao>";
}
