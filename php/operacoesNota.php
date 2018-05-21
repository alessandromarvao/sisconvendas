<?php
/**
 * ARQUIVO UTILIZADO PARA DETERMINAR A BUSCA DE NOTAS DE VENDAS.
 */

$acao = "";
$data1 = "";
$data2 = "";
$nota = "";

if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

if(isset($_POST['data1'])){
    $data1 = $_POST['data1'];
}

if(isset($_POST['data2'])){
    $data2 = $_POST['data2'];
}

if(isset($_POST['nota'])){
    $nota = $_POST['nota'];
}

if(strcmp($acao, "obterPorDia")==0){
    echo "?acao=" . base64_encode($acao) . "&data1=" . base64_encode($data1);
} elseif(strcmp($acao, "obterPorPeriodo")==0){
    echo "?acao=" . base64_encode($acao) . "&data1=" . base64_encode($data1) . "&data2=" . base64_encode($data2);
} elseif(strcmp($acao, "obterPorNota")==0){
    echo "?acao=" . base64_encode($acao) . "&id=" . base64_encode($nota);
} elseif(strcmp($acao, "listarVendasPorPeriodo")==0){
    echo "?acao=" . base64_encode($acao) . "&data1=" . base64_encode($data1) . "&data2=" . base64_encode($data2);
} else {
    echo "?acao=" . base64_encode($acao);
}