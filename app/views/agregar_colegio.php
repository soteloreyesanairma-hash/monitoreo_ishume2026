<?php
require_once "../../config/conexion.php";

$niveles = ["INICIAL", "PRIMARIA", "SECUNDARIA", "SUPERIOR", "PRONOEI", "NIDO"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $nivel  = $conexion->real_escape_string($_POST["nivel"]);
    $anio   = (int) $_POST["anio_promocion"];

    $sql = "INSERT INTO colegios (nombre, nivel, anio_promocion)
            VALUES ('$nombre', '$nivel', $anio)";
    $conexion->query($sql);

    header("Location: colegios.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar colegio - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/formulario.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/sistema.css">
</head>
<body>
    <div class="contenedor">
        <?php
        $pagina = "colegios";
        require "menu.php";
        ?>
        <main class="contenido">
            <div class="titulo">
                <h1>Agregar Colegio</h1>
                <p>Registra un nuevo colegio</p>
            </div>
            <form action="" method="POST" class="formulario">
                <div>
                    <label for="nombre">Nombre del colegio</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="nivel">Nivel</label>
                    <select id="nivel" name="nivel" required>
                        <option value="">Selecciona un nivel</option>
                        <?php foreach ($niveles as $n): ?>
                            <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="anio_promocion">Año de promocion</label>
                    <input type="number" id="anio_promocion" name="anio_promocion"
                        value="<?php echo date('Y'); ?>" required>
                </div>
                <div class="botones-formulario">
                    <button type="submit" class="btn-guardar">GUARDAR</button>
                    <a href="colegios.php" class="btn-cancelar">CANCELAR</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
