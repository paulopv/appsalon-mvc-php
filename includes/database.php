<?php

$db = mysqli_connect(
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'], 
    $_ENV['DB_NAME']);
// echo "<pre>";
// var_dump($db);
// echo"</pre>";

$db->set_charset('utf8');

if(!$db){
    echo "ERROR: no se pudo conectar a MySQL.";
    echo "errno de depuracion: " . mysqli_connect_errno();
    echo "error de depuracion: " . mysqli_connect_error();
    exit;
} 
