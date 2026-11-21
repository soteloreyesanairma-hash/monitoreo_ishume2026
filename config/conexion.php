<?php
$SERVER= "localhost";
$USER  = "root";
$PASSWORD    = "";
$BD= "monitoreo_avances_ishume2026";
$PORT= 3307;

$conexion = new mysqli(
    $SERVER,
    $USER,
    $PASSWORD,
    $BD,
    $PORT
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
?>
