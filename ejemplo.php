<?php
$x = 9876;
var_dump(is_numeric($x));
$x = "9876";
var_dump(is_numeric($x));
$x = "98.76" + 1000;
var_dump($x);
var_dump(is_numeric($x));
$x = 45;

//$e = Hola;
var_dump(is_numeric($x));
var_dump(intval("2.5",10));
var_dump(intval("3.5",10));
var_dump(intval("4.5",10));

$valor = (int) 5.6;
var_dump($valor);

