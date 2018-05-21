<?php
include_once '../cls/carrinho_compras.class.php';
include_once '../cls/entrega.class.php';
include_once '../cls/movel.class.php';
include_once '../cls/montagemDAO.class.php';
include_once '../cls/movelPossuiVendaDAO.class.php';
include_once '../cls/sessao.class.php';
include_once '../cls/vendaDAO.class.php';

// Garante que o navegador do usu�rio n�o realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da �ltima modifica��o da p�gina
header('Cache-Control: no-cache, must-revalidade'); // N�o vai ser armazenada em cache
header('Pragma: no-cache'); // N�o vai ser armazenada em cache

$cliente = "";
$vendedor = "";
$desconto = 0;
$total = "";
$endereco = "";
$referencia = "";

//Inicia as opera��es da sess�o.
$sessao = new Sessao();

if($sessao->issetSessao('cliente')){
    $cliente = $sessao->getCliente();
}

if($sessao->issetSessao("login")){
    $vendedor = $sessao->getLogin();
}

if(!empty($_POST['desconto'])){
    $aux = $_POST['desconto'];
    $array = explode(",", $aux);
    $desconto = implode(".", $array);
}

if(isset($_POST['valorTotal'])){
    $aux = explode(",", $_POST['valorTotal']);
    $total = implode(".", $aux);
}

if(isset($_POST['endereco'])){
    $endereco = utf8_decode($_POST['endereco']);
}


if(isset($_POST['referencia'])){
    $referencia = utf8_decode($_POST['referencia']);
}

//Inicia as opera��es da venda.
$venda = new VendaDAO();

//Inicia as opera��es da venda do m�vel.
$vendaMovel = new MovelPossuiVendaDAO();

//Inicia as opera��es do estoque.
$estoque = new Movel();

//Inicia as opera��es do carrinho de compra.
$carrinho = new carrinho_compras();

//Aponta o carrinho de compras a um cliente espec�fico
$carrinho->setCliente($cliente);

//Lista do carrinho de compras.
$resultado = $carrinho->obter();

//C�digos dos m�veis vendidos
$idMovel = NULL;

//Situação do móvel no estoque. 
//0 -> Não tem quantidade de móveis suficientes para realizar esta venda.
//1+ -> Tem o suficiente para realizar esta venda. 
$situacaoEstoque = 0;

//Percorre por todo o carrinho de compra.
foreach ($resultado as $linha){
    //Quantidade do m�vel comprado (a ser retirado do estoque).
    $qtde = (int) $linha['qtde_carrinho'];
    //Quantidade do m�vel no estoque
    $qtdeNoEstoque = (int) $estoque->obterQtdeEstoqueMovel($linha['id_movel_FK']);
    //Subtrai a quantidade comprada do estoque.
    $sub = $qtdeNoEstoque - $qtde;
    
    if($sub>=0){
        $situacaoEstoque++;
    }
}

$totalCarrinho = count($resultado);

//Registra Venda se a quantidade 
if($situacaoEstoque==$totalCarrinho && $venda->salvar($cliente, $vendedor, $desconto, $total, "concluída")){
    $situacaoVenda = 0;
    
    //Confere todos os cadastros no carrinho de compras.
    foreach ($resultado as $linha) {
        //Calcula a qtde de m�veis
        $contagemDosMoveis = 0;
        //calcula a situa��o da venda de cada m�vel (por linha)
        $situacaoPorLinha = 0;
        
        //Inicia as opera��es da entrega.
        $entrega = new Entrega();
        
        //Inicia as opera��es da montagem.
        $montagem = new MontagemDAO();
        
        //Recebe a �ltima nota de venda gerada (que � o desta venda).
        $idVenda = $venda->obterNotaUltimaVenda();
        
        $idMovel[$contagemDosMoveis] = $linha['id_movel_FK'];
        
        //Armazena a compra de cada m�vel do carrinho de compra
        if($vendaMovel->salvar($linha['id_movel_FK'], $idVenda, $linha['valor_unidade'], $linha['qtde_carrinho'], $linha['entrega'], $linha['montagem'])){
            $situacaoPorLinha++;
            
            //Obtem o c�digo da compra do m�vel
            $idVendaMovel = $vendaMovel->obterUltimoRegistro();
            
            //Remove do estoque a quantidade do m�vel comprado.
            if(!$estoque->removerEstoque($linha['id_movel_FK'], $linha['qtde_carrinho'])){
                echo "Falha ao remover quantidade do estoque.\n";
            } else {
                $situacaoPorLinha++;
            }
            
            //Confere se � necess�rio realizar a entrega
            if($linha['entrega']==1){
                if(!$entrega->salvar($idVendaMovel, $linha['data_entrega'], $endereco, $referencia)){
                    echo "Falha ao salvar dados da entrega.\n";
                } else {
                    $situacaoPorLinha++;
                }
            } else { //Se n�o for necess�rio realizar a entrega, adiciona mais 1 registro de OK.
                $situacaoPorLinha++;
            }
            
            //Confere se � necess�rio realizar a montagem
            if($linha['montagem']==1){
                if(!$montagem->salvar($idVendaMovel, $linha['data_montagem'])){
                    echo "Falha ao salvar dados da montagem";
                } else {
                    $situacaoPorLinha++;
                }
            } else { //Se n�o for necess�rio realizar a montagem, adiciona mais 1 registro de OK.
                $situacaoPorLinha++;
            }
            
            //Confere se todos os requisitos foram preenchidos
            if($situacaoPorLinha==4){
                $situacaoVenda++;
                $contagemDosMoveis++;
            }
            
        } else {
            echo utf8_encode("Falha ao cadastrar venda de móvel");
        }
    }
    
    //Confere se a quantidade de m�veis vendidos corresponde a quantidade de m�veis no carrinho.
    if($situacaoVenda==$totalCarrinho){
        $carrinho->removerPorCliente($cliente);
        echo utf8_encode(base64_encode($idVenda) . " ok");
    }
    
/**
 *  VENDA POR PEDIDO 
 */
} elseif($venda->salvar($cliente, $vendedor, $desconto, $total, "por pedido")){
    $situacaoVenda = 0;
    
    //Confere todos os cadastros no carrinho de compras.
    foreach ($resultado as $linha) {
        //Calcula a qtde de m�veis
        $contagemDosMoveis = 0;
        //calcula a situa��o da venda de cada m�vel (por linha)
        $situacaoPorLinha = 0;
        
        //Inicia as opera��es da entrega.
        $entrega = new Entrega();
        
        //Inicia as opera��es da montagem.
        $montagem = new MontagemDAO();
        
        //Recebe a �ltima nota de venda gerada (que � o desta venda).
        $idVenda = $venda->obterNotaUltimaVenda();
        $sessao->setVenda($idVenda);
        
        $idMovel[$contagemDosMoveis] = $linha['id_movel_FK'];
        
        //Armazena a compra de cada m�vel do carrinho de compra
        if($vendaMovel->salvar($linha['id_movel_FK'], $idVenda, $linha['valor_unidade'], $linha['qtde_carrinho'], $linha['entrega'], $linha['montagem'])){
            $situacaoPorLinha++;
            
            //Obtem o c�digo da compra do m�vel
            $idVendaMovel = $vendaMovel->obterUltimoRegistro();
            
            //Remove do estoque a quantidade do m�vel comprado.
            /*
             * DESNECESS�RIO EM CASO DE PEDIDO (M�VEL N�O EXISTE NO ESTOQUE)
             *
             * if(!$estoque->removerQuantidade($linha['id_movel_FK'], $linha['qtde_carrinho'])){
             *    echo "Falha ao remover quantidade do estoque.\n";
             * } else {
             *     $situacaoPorLinha++;
             * }
             */
            
            //Confere se � necess�rio realizar a entrega
            if($linha['entrega']==1){
                if(!$entrega->salvar($idVendaMovel, $linha['data_entrega'], $endereco, $referencia)){
                    echo "Falha ao salvar dados da entrega.\n";
                } else {
                    $situacaoPorLinha++;
                }
            } else { //Se n�o for necess�rio realizar a entrega, adiciona mais 1 registro de OK.
                $situacaoPorLinha++;
            }
            
            //Confere se � necess�rio realizar a montagem
            if($linha['montagem']==1){
                if(!$montagem->salvar($idVendaMovel, $linha['data_montagem'])){
                    echo "Falha ao salvar dados da montagem";
                } else {
                    $situacaoPorLinha++;
                }
            } else { //Se n�o for necess�rio realizar a montagem, adiciona mais 1 registro de OK.
                $situacaoPorLinha++;
            }
            
            //Confere se todos os requisitos foram preenchidos
            if($situacaoPorLinha==3){
                $situacaoVenda++;
                $contagemDosMoveis++;
            }
            
        } else {
            echo utf8_encode("Falha ao cadastrar venda de móvel");
        }
    }
    
    //Confere se a quantidade de m�veis vendidos corresponde a quantidade de m�veis no carrinho.
    if($situacaoVenda==$totalCarrinho){
        $carrinho->removerPorCliente($cliente);
        echo utf8_encode(base64_encode($idVenda) . " ok");
    }
} else {
//    echo "Cliente: ". $cliente . ", \nvendedor: " . $vendedor .", \nDesconto: " . $desconto . ",\nTotal: " . $total . "\npor pedido\n";
    echo "falha ao cadastrar venda.";
}