<?php
require_once "../../config/conexion.php";
$id = (int) $_GET["id"];

$sql = "SELECT * FROM practicantes WHERE id = $id";
$resultado = $conexion->query($sql);
$practicante = $resultado->fetch_assoc();
if (!$practicante) {
    die("No se encontro al practicante.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_colegio   = (int) $_POST["id_colegio"];
    $fecha_inicio = $conexion->real_escape_string($_POST["fecha_inicio"]);
    $fecha_limite = $conexion->real_escape_string($_POST["fecha_limite"]);

    $sqlInsert = "INSERT INTO seguimiento
                  (estado, fecha_inicio, fecha_limite, id_practicante, id_colegio)
                  VALUES ('EN PROCESO', '$fecha_inicio', '$fecha_limite', $id, $id_colegio)";
    $conexion->query($sqlInsert);

    $id_seguimiento = $conexion->insert_id;

    $sqlMaterial = "INSERT INTO materiales (estado_material, id_seguimiento)
                    VALUES ('PROCESO DE EDICIÓN', $id_seguimiento)";
    $conexion->query($sqlMaterial);

    header("Location: detalle_practicante.php?id=$id");
    exit();
}

$sqlColegios = "SELECT colegios.id_colegio, colegios.nombre, colegios.nivel
                FROM colegios
                LEFT JOIN seguimiento
                    ON colegios.id_colegio = seguimiento.id_colegio
                WHERE seguimiento.id_colegio IS NULL
                ORDER BY colegios.nombre";
$resultadoColegios = $conexion->query($sqlColegios);
$colegios = [];
while ($fila = $resultadoColegios->fetch_assoc()) {
    $colegios[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar colegio - ISHUME 2026</title>
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
                <h1>Asignar colegio</h1>
                <p>Practicante: <?php echo $practicante['nombres'] . " " . $practicante['apellidos']; ?></p>
            </div>
            <?php if (count($colegios) == 0): ?>
                <div class="mensaje">
                    <p>No hay colegios sin asignar. Primero registra uno en la seccion Colegios.</p>
                    <a href="agregar_colegio.php" class="btn-agregar">+ AGREGAR COLEGIO</a>
                </div>
            <?php else: ?>
                <form action="" method="POST" class="formulario">
                    <div>
                        <label for="id_colegio">Colegio</label>
                        <select id="id_colegio" name="id_colegio" required>
                            <option value="">Selecciona un colegio</option>
                            <?php foreach ($colegios as $colegio): ?>
                                <option value="<?php echo $colegio['id_colegio']; ?>">
                                    <?php echo $colegio['nombre'] . " (" . ($colegio['nivel'] ?? 'SIN NIVEL') . ")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="fecha_inicio">Fecha de inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio"
                            value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div>
                        <label for="fecha_limite">Fecha limite</label>
                        <input type="date" id="fecha_limite" name="fecha_limite" required>
                    </div>
                    <div class="botones-formulario">
                        <button type="submit" class="btn-guardar">ASIGNAR</button>
                        <a href="detalle_practicante.php?id=<?php echo $id; ?>" class="btn-cancelar">CANCELAR</a>
                    </div>
                </form>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
