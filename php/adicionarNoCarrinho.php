<?php
include_once '../cls/carrinho_compras.class.php';
include_once '../cls/sessao.class.php';

$cliente = "";
$movel = "";
$qtde = "";
$valor = "";
$montagem = "";
$data_montagem = "";
$entrega = "";
$data_entrega = "";
$endereco = "";
$referencia = "";

if(isset($_POST['cliente']))
    $cliente = $_POST['cliente'];

if(isset($_POST['movel']))
    $movel = $_POST['movel'];

if(isset($_POST['qtde']))
    $qtde = $_POST['qtde'];

if(isset($_POST['valor'])){
    $string = explode(",", $_POST['valor']);
    $valor = implode(".", $string);
}

if(isset($_POST['montagem']))
    $montagem = $_POST['montagem'];

if(isset($_POST['entrega']))
    $entrega = $_POST['entrega'];

if(isset($_POST['endereco']))
    $endereco = utf8_decode($_POST['endereco']);


if(isset($_POST['data_entrega']))
    $data_entrega = $_POST['data_entrega'];

if(isset($_POST['data_montagem']))
    $data_montagem = $_POST['data_montagem'];

if(isset($_POST['ref'])){ //Ponto de refer�ncia do endere�o do cliente.
    $referencia = utf8_decode($_POST['ref']);
}

$carrinhoDeCompras = new Carrinho_compras();

if($carrinhoDeCompras->salvar($cliente, $movel, $qtde, $valor, $montagem, $data_montagem, $entrega, $data_entrega)){
    if(!empty($endereco) && $entrega==1){
        $sessao = new Sessao();
        $sessao->setEndereco($endereco);
        if(!empty($referencia)){
            $sessao->setReferencia($referencia);
        }
    }
    echo "ok " . base64_encode($cliente);
} else {
    echo "fail " .  base64_encode($cliente);
}