<?php
$host = "localhost";
$user = "root";
$pass = "";
$base = "farmacia_db";
$port = 3307;                   //cambiamos el puerto a 3307 porque el 3306 ya está ocupado

$conexion = new mysqli($host, $user, $pass, $base, $port);

if($conexion->connect_error){
    die("Error de conexión: " . $conexion->connect_error);
}
?>