<?php
require_once "../../config/conexion.php";

// Nivel elegido en los filtros (vacio = todos)
$nivelFiltro = $_GET["nivel"] ?? "";
$niveles = ["INICIAL", "PRIMARIA", "SECUNDARIA", "SUPERIOR", "PRONOEI", "NIDO"];

$sql = "SELECT colegios.id_colegio, colegios.nombre, colegios.nivel,
               colegios.anio_promocion,
               CONCAT(practicantes.nombres, ' ', practicantes.apellidos) AS practicante,
               seguimiento.estado
        FROM colegios
        LEFT JOIN seguimiento
            ON colegios.id_colegio = seguimiento.id_colegio
        LEFT JOIN practicantes
            ON seguimiento.id_practicante = practicantes.id
        ORDER BY colegios.nombre";

$resultado = $conexion->query($sql);
$colegios = [];
while ($fila = $resultado->fetch_assoc()) {
    if ($nivelFiltro == "" || $nivelFiltro == $fila["nivel"]) {
        $colegios[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegios - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/tablas.css">
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
                <h1>Colegios</h1>
                <p>Colegios registrados y quien los tiene asignados</p>
            </div>
            <section class="seccion-dashboard">
                <div class="encabezado-tabla">
                    <h2>Lista de colegios (<?php echo count($colegios); ?>)</h2>
                    <a href="agregar_colegio.php" class="btn-agregar">+ AGREGAR COLEGIO</a>
                </div>
                <div class="filtros">
                    <a href="colegios.php" class="<?php if ($nivelFiltro == '') echo 'activo'; ?>">TODOS</a>
                    <?php foreach ($niveles as $n): ?>
                        <a href="colegios.php?nivel=<?php echo $n; ?>"
                           class="<?php if ($nivelFiltro == $n) echo 'activo'; ?>"><?php echo $n; ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="tabla-contenedor">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>COLEGIO</th>
                                <th>NIVEL</th>
                                <th>AÑO</th>
                                <th>PRACTICANTE</th>
                                <th>ESTADO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colegios as $colegio): ?>
                                <tr>
                                    <td><?php echo $colegio['nombre']; ?></td>
                                    <td><?php echo $colegio['nivel'] ?? 'SIN NIVEL'; ?></td>
                                    <td><?php echo $colegio['anio_promocion']; ?></td>
                                    <td><?php echo $colegio['practicante'] ?? 'Sin asignar'; ?></td>
                                    <td>
                                        <?php if ($colegio['estado'] == null): ?>
                                            -
                                        <?php else: ?>
                                            <?php
                                            $clase = "etiqueta-pendiente";
                                            if ($colegio['estado'] == 'EN PROCESO') {
                                                $clase = "etiqueta-proceso";
                                            } elseif ($colegio['estado'] == 'COMPLETADO') {
                                                $clase = "etiqueta-completado";
                                            }
                                            ?>
                                            <span class="etiqueta <?php echo $clase; ?>"><?php echo $colegio['estado']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="editar_colegio.php?id=<?php echo $colegio['id_colegio']; ?>" class="btn-accion btn-accion-claro">EDITAR</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
