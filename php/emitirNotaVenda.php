<?php
include_once '../cls/cliente.class.php';
include_once '../cls/formas_pgmntoDAO.class.php';
include_once '../cls/entrega.class.php';
include_once '../cls/montagem.class.php';
include_once '../cls/movelPossuiVendaDAO.class.php';
include_once '../cls/pagamentoDAO.class.php';
include_once '../cls/parcelasDAO.class.php';
include_once '../cls/vendaDAO.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$idVenda = 0;
$acao = "";

if(isset($_POST['idVenda'])){
    $idVenda = (int) $_POST['idVenda'];
}

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

$cliente = new Cliente();
$formasPagamento = new Formas_pgmntoDAO();
$moveis = new MovelPossuiVendaDAO();
$pagamento = new PagamentoDAO();
$parcelas = new ParcelasDAO();
$venda = new VendaDAO();

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";

if(strcmp($acao, "carregarVenda")==0){
    echo "<informacao>";
    if($venda->confereNotaDeVenda($idVenda)){
        $resultadoVenda = $venda->obterPorNotaDeVenda($idVenda);
        
        $cliente->setCPF($resultadoVenda['cpf_cliente_FK']);
        $resultadoCliente = $cliente->obter();
        echo "<vazio>";
            echo "n";
        echo "</vazio>";
        echo "<nota_venda>";
            echo "<vendedor>";
                echo utf8_encode($resultadoVenda['login_FK']);
            echo "</vendedor>";
            echo "<nome_cliente>";
                echo utf8_encode($resultadoCliente['nome_cliente']);
            echo "</nome_cliente>";
            echo "<endereco>";
                echo utf8_encode($resultadoCliente['endereco'] . ", bairro: " . $resultadoCliente['bairro']);
            echo "</endereco>";
            echo "<telefone>";
                if(!empty($resultadoCliente['tel_cliente'])){
                    echo $resultadoCliente['tel_cliente'];
                } else {
                    echo "S/N";
                }
            echo "</telefone>";
            echo "<celular1>";
                if(!empty($resultadoCliente['cel1_cliente'])){
                    echo $resultadoCliente['cel1_cliente'];
                } else {
                    echo "S/N";
                }
            echo "</celular1>";
            echo "<celular2>";
                if(!empty($resultadoCliente['cel2_cliente'])){
                    echo $resultadoCliente['cel2_cliente'];
                } else {
                    echo "S/N";
                }
            echo "</celular2>";
            echo "<data>";
                echo date('d/m/Y', strtotime($resultadoVenda['data']));
            echo "</data>";
            echo "<hora>";
                echo $resultadoVenda['hora'];
            echo "</hora>";
            echo "<desconto>";
                echo number_format($resultadoVenda['desconto'], 2, ",", "");
            echo "</desconto>";
            echo "<valor_total>";
                echo number_format($resultadoVenda['valor_total'], 2, ",", ".");
            echo "</valor_total>";
        echo "</nota_venda>";
    } else {
        echo "<vazio>";
            echo "s";
        echo "</vazio>";
    }
    echo "</informacao>";
} elseif (strcmp($acao, "carregarMoveisComprados")==0) {
    $resultado = $moveis->obterPorVenda($idVenda);
    $entrega = new Entrega();
    $montagem = new Montagem();
    echo "<moveis>";
    $total = 0;
    foreach ($resultado as $linha){
        echo "<movel>";
            echo "<id_venda>";
                echo base64_encode($linha['nota_venda_FK']);
            echo "</id_venda>";
            echo "<modelo>";
                echo utf8_encode($linha['modelo']);
            echo "</modelo>";
            echo "<fornecedor>";
                echo utf8_encode($linha['empresa']);
            echo "</fornecedor>";
            echo "<entrega>";
            //Recupera a data da entrega, caso haja.
            $resEntrega = $entrega->obter($linha['id_movel_possui_venda']);
            if(!empty($resEntrega)){
                echo date("d/m/Y", strtotime($resEntrega['data_entrega']));
            } else {
                echo 0;
            }
//                echo $linha['entrega'];
            echo "</entrega>";
            echo "<montagem>";
            //Recupera a data da montagem, caso haja.
            $resMontagem = $montagem->obter($linha['id_movel_possui_venda']);
            if(!empty($resMontagem)){
                echo date("d/m/Y", strtotime($resMontagem['data_montagem']));
            } else {
                echo 0;
            }
//                echo $linha['montagem'];
            echo "</montagem>";
            echo "<qtde>";
                echo $linha['qtde'];
            echo "</qtde>";
            echo "<valor_unitario>";
                echo number_format($linha['valor_liquido'], 2, ",", "");
            echo "</valor_unitario>";
            echo "<valor_total>";
                $aux1 = (double) $linha['valor_liquido'];
                $aux2 = (int) $linha['qtde'];
                echo number_format($aux1*$aux2, 2, ",", "");
            echo "</valor_total>";
        echo "</movel>";
        $total = $total + ($aux1*$aux2);
    }
    echo "<total_bruto>";
        echo number_format($total, 2, ",", "");
    echo "</total_bruto>";
    echo "</moveis>";
} elseif (strcmp($acao, "gerarFormasPagamento")==0) {
    $resultado = $pagamento->obterPorNotaDeVenda($idVenda);
    
    echo "<pagamentos>";
    foreach ($resultado as $linha) {
        echo "<pagamento>";
            echo "<valor_pago>";
                echo number_format($linha['valor_pago'], 2, ",", "");
            echo "</valor_pago>";
            echo "<forma_pagamento>";
                echo utf8_encode($linha['forma_pgmnto']);
            echo "</forma_pagamento>";
            if($parcelas->conferePagamentoParcelado($linha['id_pagmto'])){ //� pagamento parcelado
                $idPagmento = (int)$linha['id_pagmto'];
                $aux = $parcelas->obterPorPagamento($idPagmento);
                echo "<parcelado>";
                    echo "s";
                echo "</parcelado>";
                echo "<qtd_parcelas>";
                    echo $aux['qtde_parcelas'];
                echo "</qtd_parcelas>";
                echo "<valor_parcelas>";
                    echo number_format($aux['valor_parcela'], 2, ",", "");
                echo "</valor_parcelas>";
            } else {
                echo "<parcelado>";
                    echo "n";
                echo "</parcelado>";
            }
        echo "</pagamento>";
    }
    echo "</pagamentos>";
}