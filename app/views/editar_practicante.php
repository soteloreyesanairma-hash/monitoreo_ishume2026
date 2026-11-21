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
    $DNI       = $conexion->real_escape_string($_POST['DNI']);
    $nombres   = $conexion->real_escape_string($_POST['nombres']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $telefono  = $conexion->real_escape_string($_POST['telefono']);
    $carrera   = $conexion->real_escape_string($_POST['carrera']);

    $sqlUpdate = "UPDATE practicantes SET
                    DNI = '$DNI',
                    nombres = '$nombres',
                    apellidos = '$apellidos',
                    telefono = '$telefono',
                    carrera = '$carrera'
                  WHERE id = $id";

    $conexion->query($sqlUpdate);

    header("Location: detalle_practicante.php?id=$id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar practicante - ISHUME 2026</title>
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
                <h1>Editar informacion</h1>
                <p>Modifica los datos del practicante</p>
            </div>
            <form action="" method="POST" class="formulario">
                <div>
                    <label for="DNI">DNI</label>
                    <input type="text" id="DNI" name="DNI" maxlength="8"
                        value="<?php echo htmlspecialchars($practicante['DNI']); ?>" required>
                </div>
                <div>
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres"
                        value="<?php echo htmlspecialchars($practicante['nombres']); ?>" required>
                </div>
                <div>
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos"
                        value="<?php echo htmlspecialchars($practicante['apellidos']); ?>" required>
                </div>
                <div>
                    <label for="telefono">Telefono</label>
                    <input type="text" id="telefono" name="telefono" maxlength="9"
                        value="<?php echo htmlspecialchars($practicante['telefono']); ?>" required>
                </div>
                <div>
                    <label for="carrera">Carrera</label>
                    <input type="text" id="carrera" name="carrera"
                        value="<?php echo htmlspecialchars($practicante['carrera']); ?>" required>
                </div>
                <div class="botones-formulario">
                    <button type="submit" class="btn-guardar">GUARDAR CAMBIOS</button>
                    <a href="detalle_practicante.php?id=<?php echo $id; ?>" class="btn-cancelar">CANCELAR</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
