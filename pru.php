<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$str = 'hola (porlos parentesis) mundo donde estas';



$value = array(
    ['nombre1',"valor1"],
    ["nombre2", "valor2 a ver si veo"]
);

echo $value[1][1] ."<br>";
$a = 've';
$p=stripos($value[1][1], $a);


if ($p !== false) echo $p;
else echo "no Encuentro";



if (0!==false) echo"<br>No definido?"
?>