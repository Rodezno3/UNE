<?php
    $db_host = "localhost";
    $db_nombre = "xoxoctic";
    $db_usuario = "root";
    $db_pass = "Bobesponja.123";

    $conexionb = mysqli_connect($db_host,$db_usuario,$db_pass);
    if(mysqli_connect_errno()){
        echo "Fallo al conectar la base de datos";
        //enviarlo a otra parte de error
    }
    mysqli_select_db($conexionb,$db_nombre) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexionb,"utf8");

    try{
        $conn = new PDO("mysql:host=$db_host;dbname=$db_nombre;", $db_usuario , $db_pass);
    } catch(PDOException $e){
        die('Conexión fallida: '.$e->getMessage());
    }
?>