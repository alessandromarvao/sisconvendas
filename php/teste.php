<?php
//$valor = 300;
//$juros = 0.015;
//
//for($i=1; $i<11; $i++){
//    $valorJuros = $valor * ($juros*$i);
//    $comJuros = $valor + ($valorJuros);
//    $calculo = ($comJuros/$i);
//    echo number_format($calculo, 2, ",", "") . "<br/>";
//}

$a = "2015-08-25";
//$a = "25/08/2015";
$a = implode("-", array_reverse(explode("/", $a)));
echo $a . "<br />";
echo "Padr�o brasileiro: " .  date("d/m/Y", strtotime($a)) . "<br/>Padr�o internacional: " . date("Y-m-d", strtotime($a));