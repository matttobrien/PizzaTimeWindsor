<?php
    $hn = 'localhost';
    $db = 'obrie11g_pizzaTimeWindsor';
    $un = 'obrie11g_pizzaTimeWindsor';
    $pw = 'mamamia';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
?>