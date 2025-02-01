<?php
    require "./constantes.php";

    //var_dump(ALUMNOS);

    /* //if (!defined("CONSTANTE3")) {
        define("CONSTANTE3","Pando");
    //}
    echo "Valor de la constante 3: ".CONSTANTE3; */

    function mostrarAlumnosV(){
        global $ALUMNOS;
        var_dump($ALUMNOS);
    }


    function mostrarAlumnosC(){
        $test = ALUMNOS;
        array_push($test, "Pando");
        var_dump($test);
    }

    mostrarAlumnosC();
