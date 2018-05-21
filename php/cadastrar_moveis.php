<?php
set_time_limit(0);
include_once '../cls/movel.class.php';

$movel = new Movel();
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
                $tipo = utf8_decode($celula->nodeValue);
            } elseif($aux==1){
                $modelo = utf8_decode($celula->nodeValue);
            } elseif($aux==2){
                $fabricante = utf8_decode($celula->nodeValue);
            } elseif($aux==3){                
                $valor = number_format($celula->nodeValue, 2, ".", "");
            } else {
                $estoque = $celula->nodeValue;
            }
            $aux++;
        }   //FIM FOREACH CELULAS
        if($movel->salvar(0, $fabricante, $tipo, $modelo, $valor, $estoque, "")){
            $qtdeSalva++;
        }
        $inc++;
    }   //FIM FOREACH LINHAS
    
    echo utf8_encode("PROCESSO CONCLUÍDO.\n" . $qtdeSalva . " DE " . $inc . " MÓVEIS CADASTRADOS.");
} else {
    echo "Nenhum arquivo recebido";
}