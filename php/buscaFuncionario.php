<?php
include_once '../cls/usuario.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$acao = "";
$usuario = "";

if(isset($_POST['acao']))
    $acao = $_POST['acao'];

if(isset($_POST['usr']))
    $usuario = utf8_decode($_POST['usr']);

$usr = new Usuario();

header('Content-type: text/xml');

if(strcmp($acao, "obter") == 0){
    $usr->setLogin($usuario);
    $resultado = $usr->obter();

    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
        echo "<usuario>";
            echo "<login>";
                echo utf8_encode($resultado['login_FK']);
            echo "</login>";
            echo "<nome>";
                echo $resultado['nome'];
            echo "</nome>";
            echo "<cpf>";
                echo $resultado['cpf'];
            echo "</cpf>";
            echo "<funcao>";
                echo $resultado['funcao'];
            echo "</funcao>";
            echo "<telefone>";
            if(!empty($resultado['telefone'])){
                echo $resultado['telefone'];
            } else {
                echo " ";
            }
            echo "</telefone>";
            echo "<nascimento>";
            if(!empty($resultado['data_nasc_usr'])){
                echo date("d/m/Y", strtotime($resultado['data_nasc_usr']));
            } else {
                echo " ";
            }
            echo "</nascimento>";
            echo "<email>";
            if(!empty($resultado['email'])){
                echo $resultado['email'];
            } else {
                echo " ";
            }
            echo "</email>";
            echo "<celular1>";
            if(!empty($resultado['cel1'])){
                echo $resultado['cel1'];
            } else {
                echo " ";
            }
            echo "</celular1>";
            echo "<celular2>";
                echo $resultado['cel2'];
            echo "</celular2>";
        echo "</usuario>";
    echo "</informacao>";
}
