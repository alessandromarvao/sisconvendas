<?php
include_once '../cls/fabricanteDAO.class.php';
include_once '../cls/representanteDAO.class.php';

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

$acao = "";
$id = "";
$nome = "";
$empresa = "";
$cel1 = "";
$cel2 = "";

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(isset($_POST['empresa'])){
    $empresa = $_POST['empresa'];
}

if(isset($_POST['idRepresentante'])){
    $id = $_POST['idRepresentante'];
}

if(isset($_POST['nome'])){
    $nome = $_POST['nome'];
}

if(isset($_POST['celular1'])){
    $cel1 = $_POST['celular1'];
}

if(isset($_POST['celular2'])){
    $cel2 = $_POST['celular2'];
}

$representante = new RepresentanteDAO();

if(strcmp($acao, "salvar")==0){
    if(empty($id)){
        if($representante->salvar($empresa, $nome, $cel2, $cel1)){
            echo "ok";
        } else {
            echo "Falha ao cadastrar representante.";
        }
    } else {
        if($representante->alterar($id, $empresa, $nome, $cel2, $cel1)){
            echo "ok1";
        } else {
            echo "Não foi possível alterar informações do representante.";
        }
    }
} elseif(strcmp($acao, "obter")==0){
    $resultado = $representante->obterTodos();
    $fornecedor = new FabricanteDAO;
    header('Content-type: text/xml');
    
    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    foreach ($resultado as $linha) {
        echo "<representante>";
            echo "<id>";
                echo base64_encode($linha['id_representante']);
            echo "</id>";
            echo "<empresa>";
                $aux = $fornecedor->obterPorId($linha['id_fabricante_FK']);
                echo $aux['empresa'];
            echo "</empresa>";
            echo "<nome>";
                echo $linha['nome_representante'];
            echo "</nome>";
            echo "<celular1>";
            if(!empty($linha['cel1_representante'])){
                echo $linha['cel1_representante'];
            } else {
                echo "S/N";
            }
            echo "</celular1>";
            echo "<celular2>";
            if(!empty($linha['cel2_representante'])){
                echo $linha['cel2_representante'];
            } else {
                echo "S/N";
            }
            echo "</celular2>";
        echo "</representante>";
    }
    echo "</informacao>";
} elseif(strcmp($acao, "obterPorNome")==0){
    $resultado = $representante->pesquisarNome($nome);
    header('Content-type: text/xml');
    
    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    foreach ($resultado as $linha) {
        echo "<representante>";
            echo "<id>";
                echo $linha['id_representante'];
            echo "</id>";
            echo "<empresa>";
                $fabricante = new FabricanteDAO();
                $aux = $fabricante->obterPorId($linha['id_fabricante_FK']);
                echo $aux['empresa'];
            echo "</empresa>";
            echo "<nome>";
                echo $linha['nome_representante'];
            echo "</nome>";
            echo "<celular1>";
            if(!empty($linha['cel1_representante'])){
                echo $linha['cel1_representante'];
            } else {
                echo "S/N";
            }
            echo "</celular1>";
            echo "<celular2>";
            if(!empty($linha['cel2_representante'])){
                echo $linha['cel2_representante'];
            } else {
                echo "S/N";
            }
            echo "</celular2>";
        echo "</representante>";
    }
    echo "</informacao>";
} elseif(strcmp($acao, "obterPorFornecedor")==0){
    $fabricante = new FabricanteDAO();
    $resFab = $fabricante->pesquisar($empresa);
    
    header('Content-type: text/xml');
    
    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    
    foreach ($resFab as $linha1){
        $resultado = $representante->obterPorEmpresa($linha1['id_fabricante']);

        foreach ($resultado as $linha) {
            echo "<representante>";
                echo "<id>";
                    echo $linha['id_representante'];
                echo "</id>";
                echo "<empresa>";
                    echo $linha1['empresa'];
                echo "</empresa>";
                echo "<nome>";
                    echo $linha['nome_representante'];
                echo "</nome>";
                echo "<celular1>";
                if(!empty($linha['cel1_representante'])){
                    echo $linha['cel1_representante'];
                } else {
                    echo "S/N";
                }
                echo "</celular1>";
                echo "<celular2>";
                if(!empty($linha['cel2_representante'])){
                    echo $linha['cel2_representante'];
                } else {
                    echo "S/N";
                }
                echo "</celular2>";
            echo "</representante>";
        }
    }
    echo "</informacao>";
} elseif(strcmp($acao, "obterUnidade")==0){
    $fabricante = new FabricanteDAO();
    
    header('Content-type: text/xml');
    
    echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";
    echo "<informacao>";
    
    if(!empty($id)){
        $resultado = $representante->obterPorID($id);
        echo "<retorno>";
            echo "representante";
        echo "</retorno>";
        echo "<representante>";
            echo "<id_representante>";
                echo $resultado['id_representante'];
            echo "</id_representante>";
            echo "<id_empresa>";
                echo $resultado['id_fabricante_FK'];
            echo "</id_empresa>";
            echo "<empresa>";
                $aux = $fabricante->obterPorId($resultado['id_fabricante_FK']);
                echo $aux['empresa'];
            echo "</empresa>";
            echo "<nome>";
                echo $resultado['nome_representante'];
            echo "</nome>";
            echo "<celular1>";
            if(!empty($resultado['cel1_representante'])){
                echo $resultado['cel1_representante'];
            } else {
                echo " ";
            }
            echo "</celular1>";
            echo "<celular2>";
            if(!empty($resultado['cel2_representante'])){
                echo $resultado['cel2_representante'];
            } else {
                echo " ";
            }
            echo "</celular2>";
        echo "</representante>";
        
    } else {
        $selecoes = $fabricante->obter();
    
        echo "<retorno>";
            echo "fornecedor";
        echo "</retorno>";
        
        foreach ($selecoes as $linha) {
            echo "<fornecedor>";
                echo "<id_empresa>";
                    echo $linha['id_fabricante'];
                echo "</id_empresa>";
                echo "<empresa>";
                    echo $linha['empresa'];
                echo "</empresa>";
            echo "</fornecedor>";
        }
        
    }
    echo "</informacao>";
} elseif (strcmp($acao, "excluir")==0) {
    if($representante->remover($id)){
        echo "ok";
    } else {
        echo "Não foi possível excluír o representante selecionado";
    }
}