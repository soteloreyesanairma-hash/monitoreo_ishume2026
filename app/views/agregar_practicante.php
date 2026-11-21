<?php
require_once "../../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DNI       = $conexion->real_escape_string($_POST["DNI"]);
    $nombres   = $conexion->real_escape_string($_POST["nombres"]);
    $apellidos = $conexion->real_escape_string($_POST["apellidos"]);
    $telefono  = $conexion->real_escape_string($_POST["telefono"]);
    $carrera   = $conexion->real_escape_string($_POST["carrera"]);

    $sql = "INSERT INTO practicantes
            (DNI, nombres, apellidos, telefono, carrera)
            VALUES ('$DNI', '$nombres', '$apellidos', '$telefono', '$carrera')";

    $conexion->query($sql);

    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar practicante - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/formulario.css">
</head>
<body>
    <div class="contenedor">
        <?php
        $pagina = "inicio";
        require "menu.php";
        ?>
        <main class="contenido">
            <div class="titulo">
                <h1>Agregar Practicante</h1>
                <p>Registra un nuevo practicante</p>
            </div>
            <form action="" method="POST" class="formulario">
                <div>
                    <label for="DNI">DNI</label>
                    <input type="text" id="DNI" name="DNI" maxlength="8" required>
                </div>
                <div>
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" required>
                </div>
                <div>
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" required>
                </div>
                <div>
                    <label for="telefono">Telefono</label>
                    <input type="text" id="telefono" name="telefono" maxlength="9" required>
                </div>
                <div>
                    <label for="carrera">Carrera</label>
                    <input type="text" id="carrera" name="carrera" value="DISEÑO" required>
                </div>
                <div class="botones-formulario">
                    <button type="submit" class="btn-guardar">GUARDAR</button>
                    <a href="/monitoreo_ishume_2026/" class="btn-cancelar">CANCELAR</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
