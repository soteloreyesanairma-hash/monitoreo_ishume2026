<?php
require_once "../../config/conexion.php";
$id = (int) $_POST['id'];

// Revisar si el practicante tiene colegios asignados o en su historial
$sqlContar = "SELECT COUNT(*) AS total
              FROM seguimiento
              WHERE id_practicante = $id";
$resultadoContar = $conexion->query($sqlContar);
$filaContar = $resultadoContar->fetch_assoc();

// Si no tiene colegios, se puede eliminar
if ($filaContar["total"] == 0) {
    $sql = "DELETE FROM practicantes WHERE id = $id";
    $conexion->query($sql);

    header("Location: ../../index.php");
    exit();
}

// Si llega hasta aqui, tiene colegios: se muestra un aviso
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No se puede eliminar - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/formulario.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/sistema.css">
</head>
<body>
    <div class="contenedor">
        <?php
        $pagina = "inicio";
        require "menu.php";
        ?>
        <main class="contenido">
            <div class="titulo">
                <h1>No se puede eliminar</h1>
            </div>
            <div class="mensaje">
                <p>Este practicante tiene colegios asignados o terminados en su historial.
                   Para no perder esa informacion, no se puede eliminar.</p>
                <a href="detalle_practicante.php?id=<?php echo $id; ?>" class="btn-cancelar">VOLVER AL DETALLE</a>
            </div>
        </main>
    </div>
</body>
</html>
