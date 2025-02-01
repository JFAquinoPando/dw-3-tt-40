<?php
    // Booleano a entero
    /* $R = intval(TRUE+FALSE+TRUE, 10);
    var_dump($R);
    var_dump([false]); */
    var_dump([
        boolval(15000),
        boolval(0),
        boolval(-15000),
    ]);

    $v1 = [""];
    $v2 = !!$v1;
    var_dump($v2);
