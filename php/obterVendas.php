<?php
include_once '../cls/vendaDAO.class.php';
include_once '../cls/formas_pgmntoDAO.class.php';

/* 
 * P�gina destinada � busca das Notas de Vendas.
 * Acesso Administrativo apenas.
 * 
 * @author Alessandro Marv�o (alessandromarvao@gmail.com)
 */


// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$acao = "";
$data1 = "";
$data2 = "";

$venda = new VendaDAO();
$pagamento = new Formas_pgmntoDAO();

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(isset($_POST['data1'])){
    $data1 = $_POST['data1'];
}

if(isset($_POST['data2'])){
    $data2 = $_POST['data2'];
}

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='Windows-1252' standalone='yes'?>";

if(strcmp($acao, "obterTodos")==0){
    $resultado = $venda->obterTodos();
    $periodo = "TOTAL";
} elseif(strcmp($acao, "obterPorDia")==0){
    $resultado = $venda->obterPorData($data1);
    $periodo = date("d/m/Y", strtotime($data1));
} elseif(strcmp($acao, "obterPorPeriodo")==0){
    $resultado = $venda->obterPorIntervaloDatas($data1, $data2);
    $periodo = date("d/m/Y", strtotime($data1)) . " a " . date("d/m/Y", strtotime($data2));
}elseif(strcmp($acao, "obterRecebimentosPorDia")==0){
    $resultado = $venda->obterFormasDePagamentosPorDia($data1);
} elseif(strcmp($acao, "obterRecebimentosPorPeriodo")==0){
    $resultado = $venda->obterFormasDePagamentoPorPeriodo($data1, $data2);
} elseif(strcmp($acao, "obterTodosRecebimentos")==0){
    $resultado = $venda->obterFormasDePagamentos();
} elseif(strcasecmp($acao, "listarVendasPorPeriodo")==0){
    $periodo = date("d/m/Y", strtotime($data1)) . " a " . date("d/m/Y", strtotime($data2));
    $resultado = $venda->listarPorVendedor($data1, $data2);
}

if(strcmp($acao, "obterTodos")==0 || strcmp($acao, "obterPorDia")==0 || strcmp($acao, "obterPorPeriodo")==0){
    echo "<vendas>";
    echo "<periodo>";
        echo $periodo;
    echo "</periodo>";
    foreach ($resultado as $linha) {
        echo '<venda>';
            echo "<nota>";
                echo $linha['nota_venda'];
            echo "</nota>";
            echo "<valor>";
                echo number_format($linha['valor_total'], 2, ",", "");
            echo "</valor>";
            echo "<nota_codificada>";
                echo base64_encode($linha['nota_venda']);
            echo "</nota_codificada>";
        echo '</venda>';
    }
    echo "</vendas>";
} elseif (strcmp($acao, "obterRecebimentosPorDia")==0 || strcmp($acao, "obterRecebimentosPorPeriodo")==0 || strcmp($acao, "obterTodosRecebimentos")==0){
    $resPagamentos = $pagamento->obterTodos(); //Recupera todas as formas de pagamento
    echo "<pagamentos>";
    $valor = 0.0;
    foreach ($resPagamentos as $linha){
        $pg = "00,00";
        echo "<pagamento>";
        foreach ($resultado as $aux){
            if(strcmp($linha['forma_pgmnto'], $aux['forma_pgmnto'])==0){
                $pg = number_format($aux['total'], 2, ",", ".");
                $valor = number_format($valor + (double) $aux['total'], 2, ".", "");
            }
        }
            echo "<forma>";
                echo utf8_encode($linha['forma_pgmnto']);
            echo "</forma>";
            echo "<valor_pago>";
                echo $pg;
            echo "</valor_pago>";
        echo "</pagamento>";
    }
    echo "<pagamento>";
        echo "<forma>";
            echo "TOTAL:";
        echo "</forma>";
        echo "<valor_pago>";
            echo number_format($valor, 2, ",", ".");
        echo "</valor_pago>";
    echo "</pagamento>";
    echo "</pagamentos>";
} elseif(strcmp($acao, "listarVendasPorPeriodo")==0){
    echo "<informacao>";
        echo "<periodo>";
            echo $periodo;
        echo "</periodo>";
        echo "<vendedores>";
        foreach ($resultado as $linha) {
            echo "<vendedor>";
                echo "<nome>";
                    echo utf8_encode($linha['nome']);
                echo "</nome>";
                echo "<cpf>";
                    echo $linha['cpf'];
                echo "</cpf>";
                echo "<vendas>";
                    echo $linha['vendas'];
                echo "</vendas>";
                echo "<valor_total>";
                    echo number_format($linha['total'], 2, ",", ".");
                echo "</valor_total>";
            echo "</vendedor>";
        }
        echo "</vendedores>";
    echo "</informacao>";
}