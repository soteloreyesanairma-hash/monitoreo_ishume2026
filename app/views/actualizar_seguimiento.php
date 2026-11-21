<?php
require_once "../../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = (int) $_POST["id_seguimiento"];
    $accion = $_POST["accion"];

    if ($accion == "iniciar") {
        $sql = "UPDATE seguimiento
                SET estado = 'EN PROCESO'
                WHERE id_seguimiento = $id";
        $conexion->query($sql);
    } elseif ($accion == "completar") {
        $sql = "UPDATE seguimiento
                SET estado = 'COMPLETADO', fecha_fin = CURDATE()
                WHERE id_seguimiento = $id";
        $conexion->query($sql);
    }
}

header("Location: seguimiento.php");
exit();
?>
