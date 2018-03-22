<?php 
require_once('config/FrontController.php');

FrontController::main();
/*
	echo 'hello world';

    $host="localhost";
    $port="5432";
    $user="postgres";
    $pass="postgres";
    $dbname="Mascotas";

    // Conectando y seleccionado la base de datos  
    $connect = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass")
    or die('No se ha podido conectar: ' . pg_last_error());

    if(!$connect)
        echo "<p><i>No me conecte</i></p>";
    else
        echo "<p><i>Me conecte</i></p>";

    pg_close($connect);
    */
?>