<?php
include_once '../cls/cliente.class.php';
include_once '../cls/entrega.class.php';
include_once '../cls/montagemDAO.class.php';
include_once '../cls/movelPossuiVendaDAO.class.php';
include_once '../cls/vendaDAO.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$nota = base64_decode("MjgwMDI=");
$entregas = 0;
$montagens = 0;

if(isset($_POST['idVenda'])){
    $nota = (int) $_POST['idVenda'];
}

$vendaDeMovel = new MovelPossuiVendaDAO();
$venda = new VendaDAO();
$cliente = new Cliente();
$entrega = new Entrega();
$montagem = new MontagemDAO();

$resultadoVenda = $venda->obterPorNotaDeVenda($nota);
$resultadoMoveis = $vendaDeMovel->obterPorVenda($nota);

foreach ($resultadoMoveis as $linha){
    if($linha['entrega']==1){
        $entregas++;
    }
    if($linha['montagem']==1){
        $montagens++;
    }
}

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='WINDOWS-1252' standalone='yes'?>\n";

 
echo "<informacao>";
if($nota!==0){
    echo "<cliente>";
        $cliente->setCPF($resultadoVenda['cpf_cliente_FK']);
        $resultadoCliente = $cliente->obter();
        echo "<nome>";
            echo utf8_encode($resultadoCliente['nome_cliente']);
        echo "</nome>";
        echo "<endereco_cliente>";
            echo utf8_encode($resultadoCliente['endereco'] . ", " . $resultadoCliente['bairro']);
        echo "</endereco_cliente>";
        echo "<ref_cliente>";
            echo utf8_encode($resultadoCliente['pto_referencia']);
        echo "</ref_cliente>";
        echo "<telefone>";
        //Confere se o n�mero do telefone do cliente existe e possui 13 caracteres "(##)####-####"
        if(!empty($resultadoCliente['tel_cliente']) && strlen($resultadoCliente['tel_cliente'])==13){
            echo $resultadoCliente['tel_cliente'];
        } else {
            echo "S/N";
        }
        echo "</telefone>";
        echo "<celular1>";
        //Confere se o n�mero do celular do cliente existe e possui 14 caracteres "(##)#####-####"
        if(!empty($resultadoCliente['cel1_cliente']) && strlen($resultadoCliente['cel1_cliente'])==14){
            echo $resultadoCliente['cel1_cliente'];
        } else {
            echo "S/N";
        }
        echo "</celular1>";
        echo "<celular2>";
        //Confere se o n�mero do celular do cliente existe e possui 14 caracteres "(##)#####-####"
        if(!empty($resultadoCliente['cel1cliente']) && strlen($resultadoCliente['cel2_cliente'])==14){
            echo $resultadoCliente['cel2_cliente'];
        } else {
            echo "S/N";
        }
        echo "</celular2>";
    echo "</cliente>";
    echo "<venda>";
        echo "<nota_venda>";
            echo $resultadoVenda['nota_venda'];
        echo "</nota_venda>";
        echo "<vendedor>";
            echo $resultadoVenda['login_FK'];
        echo "</vendedor>";
        echo "<data>";
            echo date("d/m/Y", strtotime($resultadoVenda['data']));
        echo "</data>";
    echo "</venda>";
    if($entregas>0){
        echo "<tem_entregas>";
            echo "s";
        echo "</tem_entregas>";
        echo "<entregas>";
        foreach ($resultadoMoveis as $linha) {
            $entrega->setVendaMovel($linha['id_movel_possui_venda']);
            $resultadoEntrega = $entrega->obter();
            if (count($resultadoEntrega)==4){
                echo "<entrega>";
                    echo "<modelo>";
                        echo utf8_encode($linha['modelo'] . " " . $linha['empresa']);
                    echo "</modelo>";
                    echo "<qtde>";
                    if($linha['qtde']<10){
                        echo "0" . $linha['qtde'];
                    } else {
                        echo $linha['qtde'];
                    }
                    echo "</qtde>";
                    $resEntrega = $entrega->obter($linha['id_movel_possui_venda']);
                    echo "<data>";
                        echo date("d/m/Y", strtotime($resEntrega['data_entrega']));
                    echo "</data>";
                    echo "<endereco>";
                        echo utf8_encode($resultadoEntrega['end_entrega']);
                    echo "</endereco>";
                    echo "<referencia>";
                    $referencia = "S/R";
                    if(isset($resultadoEntrega['referencia_entrega'])){
                        $referencia = utf8_encode($resultadoEntrega['referencia_entrega']);
                    }
                        echo $referencia;
                    echo "</referencia>";
                echo "</entrega>";
            }
        }
        echo "</entregas>";
    } else {
        echo "<tem_entregas>";
            echo "n";
        echo "</tem_entregas>";
    }
    if($montagens>0){
        echo "<tem_montagens>";
            echo "s";
        echo "</tem_montagens>";
        echo "<montagens>";
        foreach ($resultadoMoveis as $linha) {
            $resultadoMontagem = $montagem->obterPorMovelVendido($linha['id_movel_possui_venda']);
            if($linha['id_movel_possui_venda']==$resultadoMontagem['id_movel_possui_venda_FK']){
                echo "<montagem>";
                    echo "<modelo>";
                        echo utf8_encode($linha['modelo'] . " " . $linha['empresa']);
                    echo "</modelo>";
                    $resMontagem = $montagem->obterPorMovelVendido($linha['id_movel_possui_venda']);
                    echo "<data>";
                        echo date("d/m/Y", strtotime($resMontagem['data_montagem']));
                    echo "</data>";
                    echo "<qtde>";
                        if($linha['qtde']<10){
                            echo "0" . $linha['qtde'];
                        } else {
                            echo $linha['qtde'];
                        }
                    echo "</qtde>";
                echo "</montagem>";
            }
        }
        echo "</montagens>";
    } else {
        echo "<tem_montagens>";
            echo "n";
        echo "</tem_montagens>";
    }
}
echo "</informacao>";