<?php

/*Imprimira:
Array ([0] => 10 [1] => 20 [2] => 30 [3] => 40)
*/
    $arr1 = array(
        10,
        20,
        30,
        40
    );
    print_r($arr1);
    echo "<br>";

/*Imprimira:
Array ([0] => 10 [1] => 20 [2] => 30 [3] => 40 [4] => 5)
*/
    $arr1[] = 5;
    print_r($arr1);
    echo "<br>";

/*Imprimira:
Array ([0] => 10 [1] => 20 [2] => 30 [3] => 40 [4] => 5 [12] => 6 [11] => 5 [13] => 5)
*/
    $arr1[12] = 6;
    $arr1[11] = 5;
    $arr1[] = 5;
    print_r($arr1);
    echo "<br>";
?>