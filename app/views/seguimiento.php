<?php
require_once "../../config/conexion.php";

// Estado elegido en los filtros (vacio = todos)
$estadoFiltro = $_GET["estado"] ?? "";
$estados = ["PENDIENTE", "EN PROCESO", "COMPLETADO"];

$sql = "SELECT seguimiento.id_seguimiento,
               practicantes.id AS id_practicante,
               CONCAT(practicantes.nombres, ' ', practicantes.apellidos) AS practicante,
               colegios.nombre AS colegio,
               colegios.nivel,
               seguimiento.estado,
               seguimiento.fecha_inicio,
               seguimiento.fecha_limite,
               seguimiento.fecha_fin
        FROM seguimiento
        INNER JOIN practicantes ON seguimiento.id_practicante = practicantes.id
        INNER JOIN colegios ON seguimiento.id_colegio = colegios.id_colegio
        ORDER BY seguimiento.id_seguimiento DESC";

$resultado = $conexion->query($sql);
$asignaciones = [];
while ($fila = $resultado->fetch_assoc()) {
    if ($estadoFiltro == "" || $estadoFiltro == $fila["estado"]) {
        $asignaciones[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/tablas.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/sistema.css">
</head>
<body>
    <div class="contenedor">
        <?php
        $pagina = "seguimiento";
        require "menu.php";
        ?>
        <main class="contenido">
            <div class="titulo">
                <h1>Seguimiento</h1>
                <p>Avance de cada practicante con el colegio que edita</p>
            </div>
            <section class="seccion-dashboard">
                <div class="encabezado-tabla">
                    <h2>Asignaciones (<?php echo count($asignaciones); ?>)</h2>
                </div>
                <div class="filtros">
                    <a href="seguimiento.php" class="<?php if ($estadoFiltro == '') echo 'activo'; ?>">TODOS</a>
                    <?php foreach ($estados as $e): ?>
                        <a href="seguimiento.php?estado=<?php echo $e; ?>"
                           class="<?php if ($estadoFiltro == $e) echo 'activo'; ?>"><?php echo $e; ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="tabla-contenedor">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>PRACTICANTE</th>
                                <th>COLEGIO</th>
                                <th>NIVEL</th>
                                <th>ESTADO</th>
                                <th>INICIO</th>
                                <th>LIMITE</th>
                                <th>FIN</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asignaciones as $a): ?>
                                <tr>
                                    <td>
                                        <a href="detalle_practicante.php?id=<?php echo $a['id_practicante']; ?>"><?php echo $a['practicante']; ?></a>
                                    </td>
                                    <td><?php echo $a['colegio']; ?></td>
                                    <td><?php echo $a['nivel'] ?? '-'; ?></td>
                                    <td>
                                        <?php
                                        $clase = "etiqueta-pendiente";
                                        if ($a['estado'] == 'EN PROCESO') {
                                            $clase = "etiqueta-proceso";
                                        } elseif ($a['estado'] == 'COMPLETADO') {
                                            $clase = "etiqueta-completado";
                                        }
                                        ?>
                                        <span class="etiqueta <?php echo $clase; ?>"><?php echo $a['estado']; ?></span>
                                    </td>
                                    <td><?php echo $a['fecha_inicio'] ?? '-'; ?></td>
                                    <td><?php echo $a['fecha_limite'] ?? '-'; ?></td>
                                    <td><?php echo $a['fecha_fin'] ?? '-'; ?></td>
                                    <td>
                                        <?php if ($a['estado'] == 'PENDIENTE'): ?>
                                            <form action="actualizar_seguimiento.php" method="POST" class="form-en-linea">
                                                <input type="hidden" name="id_seguimiento" value="<?php echo $a['id_seguimiento']; ?>">
                                                <input type="hidden" name="accion" value="iniciar">
                                                <button type="submit" class="btn-accion">INICIAR</button>
                                            </form>
                                        <?php elseif ($a['estado'] == 'EN PROCESO'): ?>
                                            <form action="actualizar_seguimiento.php" method="POST" class="form-en-linea"
                                                onsubmit="return confirm('¿Marcar este colegio como completado?');">
                                                <input type="hidden" name="id_seguimiento" value="<?php echo $a['id_seguimiento']; ?>">
                                                <input type="hidden" name="accion" value="completar">
                                                <button type="submit" class="btn-accion">COMPLETAR</button>
                                            </form>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
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
