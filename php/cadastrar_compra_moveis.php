<?php
set_time_limit(0);
include_once '../cls/compra.class.php';
include_once '../cls/movel.class.php';

$movel = new Compra();
$estoque = new Movel();

$qtdeSalva = 0;

if($_FILES['xml']['tmp_name'] && strcmp($_FILES['xml']['type'], "text/xml")==0){
    $dom = DOMDocument::load($_FILES['xml']['tmp_name']);
    $linhas = $dom->getElementsByTagName("Row");
    $inc = 0;
    //Percorre todas as linhas do arquivo
    foreach ($linhas as $linha){
        $celulas = $linha->getElementsByTagName("Cell");
        $aux = 0;
        //Percorre todas as células da linha selecionada
        foreach ($celulas as $celula){
            if($aux==0){
                $id = utf8_decode($celula->nodeValue);
            } elseif($aux==1){
                $valor = utf8_decode($celula->nodeValue);
            } elseif($aux==2){
                $qtde = utf8_decode($celula->nodeValue);
            }
            $aux++;
        }   //FIM FOREACH CELULAS
        if($movel->salvar(0, $id, $valor, $qtde) && $estoque->adicionarEstoque($id, $qtde) ){
            $qtdeSalva++;
        }
        $inc++;
    }   //FIM FOREACH LINHAS
    
    echo utf8_encode("PROCESSO CONCLUÍDO.\n" . $qtdeSalva . " DE " . $inc . " MÓVEIS SALVOS.");
} else {
    echo "Nenhum arquivo recebido";
}