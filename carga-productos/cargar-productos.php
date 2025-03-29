<?php
//var_dump($_FILES);

$archivo = fopen($_FILES["archivo"]["tmp_name"], "r");

$productos=explode("\n",fread($archivo, 999999));

$posiciones = [
    "id" => 0,
    "name" => null,
    "images" => 32,
    "regular_price" => null 
];
$claves = explode(",",$productos[0]);


function limpiar($c){
    $texto = strtolower($c); // paso 1
    $texto = str_replace('"', '', $texto); // paso 2
    $texto = str_replace(' ', '_', $texto); // paso 3
    return $texto;
}

$claves = array_map("limpiar", $claves);

/* 
Name,Published,"Is featured?","Visibility in catalog"---->
0 -> Name                       | name (paso 1), name (paso 2), name (paso 3)
1 -> Published                  | published (paso 1), published (paso 2), published (paso 3)
2 -> "Is featured?"             | "is featured" (paso 1), is featured (paso 2), is_featured (paso 3)
3 -> "Visibility in catalog"    |"visibility in catalog" (p 1), visibility in catalog (p2), visibility_in_catalog (p3), 
*/





$posicionesClaves = array_keys($posiciones) ;
for ($i=0; $i < sizeof($claves); $i++) {
    for ($p=0; $p < sizeof($posicionesClaves); $p++) { 
        if ($posicionesClaves[$p]  == $claves[$i] && 
            $posiciones[$posicionesClaves[$p]] === null) {
            $posiciones[$posicionesClaves[$p]] = $i;
        }
    }
}
/* Array ( [id] => 0 [name] => 3 [images] => 28 , precio => 24 ) */
$sql = "INSERT INTO productos (campo1, campo2, campo3) VALUES ";

/* 
$sql = "INSERT INTO productos (campo1, campo2, campo3) 
    VALUES
    ('{$producto}', '{$precio}', '{$imagen}')";
*/

$sacarProductos = [];
foreach ($productos as $key => $producto) {
    if ($key === 0) {
        continue;
    }
    $prod = [];
    $fila =explode(",", $producto);
    //print_r($fila);
    foreach ($posiciones as $k => $v) {
        if (!array_key_exists($v,$fila)) {
            continue;
        }
        $prod[] = $fila[$v];
    }
    $sacarProductos[] = $prod;
    if (sizeof($sacarProductos) == 12) {
        break;
    }
    
}

//print_r($sacarProductos);
$ins = [];
for ($i=0; $i < sizeof($sacarProductos); $i++) { 
    $nombre = limpiar($sacarProductos[$i][1]);
    $imagen = limpiar($sacarProductos[$i][2]);
    $ins[] = "('{$nombre}', {$sacarProductos[$i][3]}, '{$imagen}')";
}

$valores =implode(",", $ins);

$sql .= $valores;

//echo $sql;

include "./php/conexion.php";
$res = $conexion->query($sql);

echo "<h3>INSERCIÓN REALIZADA</h3>";


/* 
$posiciones = [
    id => null,
    name => null,
    image => null
]

$productos =
[0] => ID,Type,SKU,Name,Published,"Is featured?",
[1] => 1,2,15212,"texto",...

$claves = explode(",",$productos[0])
$claves = [
    0 => ID
    1 => type
    2 => SKU,
    3 => ...
    .......
]

for (){
    array_key_exists( strtolower($claves[$i])  , $posiciones){
        $posiciones[strtolower($claves[$i])] = $i
    }
}

$posiciones = [
    id => 0,
    name => 4,
    image => 21
]
*/