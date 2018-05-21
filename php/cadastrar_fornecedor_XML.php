<?php
include_once '../cls/fabricante.class.php';

$fabricante = new Fabricante();

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
            $nome = "";
            $contato = "";
            $tel = "";
            $cel = "";
            $rep = "";
            $cel1_rep = "";
            $cel2_rep = "";
            if($aux==0){
                $nome = utf8_decode($celula->nodeValue);
            } elseif($aux==1){
                $contato = utf8_decode($celula->nodeValue);
            } elseif($aux==2){
                $tel = utf8_decode($celula->nodeValue);
            } elseif($aux==3){
                $cel = utf8_decode($celula->nodeValue);
            } elseif($aux==4){
                $rep = utf8_decode($celula->nodeValue);
            } elseif($aux==5){
                $cel1_rep = utf8_decode($celula->nodeValue);
            } elseif($aux==6){
                $cel2_rep = utf8_decode($celula->nodeValue);
            }
            $aux++;
        }   //FIM FOREACH CELULAS
        
        if($fabricante->salvar(0, $nome, $contato, $tel, $cel, $rep, $cel1_rep, $cel2_rep)){
            $qtdeSalva++;
        }
        $inc++;
    }   //FIM FOREACH LINHAS
    $msg = "PROCESSO CONCLUÍDO.\n" . $qtdeSalva . " DE " . $inc . " FORNECEDORES SALVOS.";
} else {
    $msg = "Nenhum arquivo recebido";
}

echo utf8_encode($msg);
