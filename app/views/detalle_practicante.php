<?php
require_once "../../config/conexion.php";
$id = (int) $_GET["id"];

// 1) Datos del practicante
$sql = "SELECT * FROM practicantes WHERE id = $id";
$resultado = $conexion->query($sql);
$practicante = $resultado->fetch_assoc();
if (!$practicante) {
    die("No se encontro al practicante.");
}

// 2) Colegios que tiene ahora
$sqlActuales = "SELECT colegios.nombre, colegios.nivel, seguimiento.estado,
                       seguimiento.fecha_inicio, seguimiento.fecha_limite
                FROM seguimiento
                INNER JOIN colegios ON seguimiento.id_colegio = colegios.id_colegio
                WHERE seguimiento.id_practicante = $id
                  AND seguimiento.estado IN ('PENDIENTE', 'EN PROCESO')
                ORDER BY seguimiento.fecha_inicio";
$resultadoActuales = $conexion->query($sqlActuales);
$actuales = [];
while ($fila = $resultadoActuales->fetch_assoc()) {
    $actuales[] = $fila;
}

// 3) Historial: colegios que ya termino
$sqlHistorial = "SELECT colegios.nombre, colegios.nivel, colegios.anio_promocion,
                        seguimiento.fecha_inicio, seguimiento.fecha_fin
                 FROM seguimiento
                 INNER JOIN colegios ON seguimiento.id_colegio = colegios.id_colegio
                 WHERE seguimiento.id_practicante = $id
                   AND seguimiento.estado = 'COMPLETADO'
                 ORDER BY seguimiento.fecha_fin DESC";
$resultadoHistorial = $conexion->query($sqlHistorial);
$historial = [];
while ($fila = $resultadoHistorial->fetch_assoc()) {
    $historial[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del practicante - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/detalle.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/tablas.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/sistema.css">
</head>
<body>
    <div class="contenedor">
        <?php
        $pagina = "inicio";
        require "menu.php";
        ?>
        <main class="contenido">
            <a href="/monitoreo_ishume_2026/" class="volver">
                <- Volver a practicantes
            </a>
            <div class="titulo-detalle">
                <h1>DETALLE DEL PRACTICANTE</h1>
            </div>
            <div class="detalle-contenido">
                <section class="tarjeta-detalle informacion-personal">
                    <div class="titulo-tarjeta">
                        <h2>INFORMACION PERSONAL</h2>
                        <span class="estado-detalle">- ACTIVO</span>
                    </div>
                    <div class="dato">
                        <span>DNI</span>
                        <strong><?php echo $practicante['DNI']; ?></strong>
                    </div>
                    <div class="dato">
                        <span>Nombres</span>
                        <strong><?php echo $practicante['nombres']; ?></strong>
                    </div>
                    <div class="dato">
                        <span>Apellidos</span>
                        <strong><?php echo $practicante['apellidos']; ?></strong>
                    </div>
                    <div class="dato">
                        <span>Telefono</span>
                        <strong><?php echo $practicante['telefono']; ?></strong>
                    </div>
                    <div class="dato">
                        <span>Carrera</span>
                        <strong><?php echo $practicante['carrera']; ?></strong>
                    </div>
                </section>
                <section>
                    <div class="informacion-lateral">
                        <section class="tarjeta-pequena">
                            <h2>COLEGIOS ACTUALES</h2>
                            <?php if (count($actuales) == 0): ?>
                                <p class="texto-vacio">Sin colegio asignado</p>
                            <?php else: ?>
                                <?php foreach ($actuales as $colegio): ?>
                                    <div class="colegio-actual">
                                        <strong><?php echo $colegio['nombre']; ?></strong>
                                        <p>
                                            <?php echo $colegio['nivel']; ?> -
                                            <?php echo $colegio['estado']; ?> -
                                            Limite: <?php echo $colegio['fecha_limite'] ?? 'sin fecha'; ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </section>
                        <section class="tarjeta-pequena">
                            <h2>COLEGIOS TERMINADOS</h2>
                            <strong><?php echo count($historial); ?></strong>
                        </section>
                    </div>
                </section>
            </div>

            <div class="bloque">
                <h2>HISTORIAL DE COLEGIOS</h2>
                <?php if (count($historial) == 0): ?>
                    <p class="texto-vacio">Aun no termina ningun colegio.</p>
                <?php else: ?>
                    <div class="tabla-contenedor">
                        <table class="tabla-datos">
                            <thead>
                                <tr>
                                    <th>COLEGIO</th>
                                    <th>NIVEL</th>
                                    <th>AÑO</th>
                                    <th>INICIO</th>
                                    <th>FIN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historial as $h): ?>
                                    <tr>
                                        <td><?php echo $h['nombre']; ?></td>
                                        <td><?php echo $h['nivel']; ?></td>
                                        <td><?php echo $h['anio_promocion']; ?></td>
                                        <td><?php echo $h['fecha_inicio']; ?></td>
                                        <td><?php echo $h['fecha_fin']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="acciones-detalle">
                <a href="asignar_colegio.php?id=<?php echo $practicante['id']; ?>" class="btn-editar-detalle">
                    ASIGNAR COLEGIO</a>
                <a href="editar_practicante.php?id=<?php echo $practicante['id']; ?>" class="btn-editar-detalle">
                    EDITAR INFORMACION</a>
                <form action="eliminar_practicante.php" method="POST"
                    onsubmit="return confirm('¿Estas seguro que deseas eliminar este practicante?');">
                    <input type="hidden" name="id" value="<?php echo $practicante['id']; ?>">
                    <button type="submit" class="btn-eliminar-detalle">ELIMINAR</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
