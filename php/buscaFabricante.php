<?php
include_once '../cls/fabricante.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$acao = "";
$nome = "";
$rep = "";
$id = "";

if(isset($_POST['acao']))
    $acao = $_POST['acao'];

if(isset($_POST['empresa']))
    $nome = utf8_decode($_POST['empresa']);

if(isset($_POST['representante']))
    $rep = utf8_decode($_POST['representante']);

if(isset($_POST['id']))
    $id = utf8_decode($_POST['id']);

$fornecedor = new Fabricante();

header('Content-type: text/xml');

echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";

if(strcmp($acao, "obter") == 0){
    $fornecedor->setEmpresa($nome);
    $resultado = $fornecedor->obter($nome);
} elseif(strcmp($acao, "obterPorID")==0){
    $fornecedor->setId(base64_decode($id));
    $resultado = $fornecedor->obter();
} elseif (strcmp($acao, "pesquisar")==0) {
    if(!empty($rep)){
        $fornecedor->setRepresentante($rep);
        $resultado = $fornecedor->obter();
    } else {
        $fornecedor->setEmpresa($nome);
        $resultado = $fornecedor->obter();
    }
} elseif(strcmp($acao, "pesquisarTodos")==0){
    $resultado = $fornecedor->obter();
}

if(strcmp($acao, "obterPorID")==0){
    echo "<fornecedor>";
        echo "<nome>";
            echo $resultado['empresa'];
        echo "</nome>";
        echo "<contato>";
        if(!empty($resultado['contato'])){
            echo $resultado['contato'];
        } else {
            echo "S/N";
        }
        echo "</contato>";
        echo "<telefone>";
        if(!empty($resultado['tel_empresa'])){
            echo $resultado['tel_empresa'];
        } else {
            echo "S/N";
        }
        echo "</telefone>";
        echo "<celular>";
        if(!empty($resultado['cel_empresa'])){
            echo $resultado['cel_empresa'];
        } else {
            echo "S/N";
        }
        echo "</celular>";
        echo "<representante>";
        if(!empty($resultado['representante'])){
            echo $resultado['representante'];
        } else {
            echo " ";
        }
        echo "</representante>";
        echo "<cel1_representante>";
        if(!empty($resultado['cel1_representante'])){
            echo $resultado['cel1_representante'];
        } else {
            echo "S/N";
        }
        echo "</cel1_representante>";
        echo "<cel2_representante>";
        if(!empty($resultado['cel2_representante'])){
            echo $resultado['cel2_representante'];
        } else {
            echo "S/N";
        }
        echo "</cel2_representante>";
        echo "<id>";
            echo $resultado['id_fabricante'];
        echo "</id>";
        echo "<idB64>";
            echo base64_encode($resultado['id_fabricante']);
        echo "</idB64>";
    echo "</fornecedor>"; 
} else {
    echo "<informacao>";
    foreach ($resultado as $linha){
            echo "<fornecedor>";
                echo "<nome>";
                    echo $linha['empresa'];
                echo "</nome>";
                echo "<contato>";
                if(!empty($linha['contato'])){
                    echo $linha['contato'];
                } else {
                    echo "S/N";
                }
                echo "</contato>";
                echo "<telefone>";
                if(!empty($linha['tel_empresa'])){
                    echo $linha['tel_empresa'];
                } else {
                    echo "S/N";
                }
                echo "</telefone>";
                echo "<celular>";
                if(!empty($linha['cel_empresa'])){
                    echo $linha['cel_empresa'];
                } else {
                    echo "S/N";
                }
                echo "</celular>";
                echo "<representante>";
                if(!empty($linha['representante'])){
                    echo $linha['representante'];
                } else {
                    echo " ";
                }
                echo "</representante>";
                echo "<cel1_representante>";
                if(!empty($linha['cel1_representante'])){
                    echo $linha['cel1_representante'];
                } else {
                    echo "S/N";
                }
                echo "</cel1_representante>";
                echo "<cel2_representante>";
                if(!empty($linha['cel2_representante'])){
                    echo $linha['cel2_representante'];
                } else {
                    echo "S/N";
                }
                echo "</cel2_representante>";
                echo "<id>";
                    echo $linha['id_fabricante'];
                echo "</id>";
                echo "<idB64>";
                    echo base64_encode($linha['id_fabricante']);
                echo "</idB64>";
            echo "</fornecedor>";        
    }
    echo "</informacao>";
}
