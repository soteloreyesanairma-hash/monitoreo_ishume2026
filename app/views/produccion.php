<?php
require_once "../../config/conexion.php";

// 1) Si se pulso un boton, guardar el paso de produccion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id   = (int) $_POST["id_seguimiento"];
    $paso = $_POST["paso"];

    // Si todavia no existe su fila en materiales, se crea
    $sqlExiste = "SELECT COUNT(*) AS total FROM materiales WHERE id_seguimiento = $id";
    $resultadoExiste = $conexion->query($sqlExiste);
    $filaExiste = $resultadoExiste->fetch_assoc();
    if ($filaExiste["total"] == 0) {
        $sqlCrear = "INSERT INTO materiales (estado_material, id_seguimiento)
                     VALUES ('PROCESO DE EDICIÓN', $id)";
        $conexion->query($sqlCrear);
    }

    if ($paso == "impreso") {
        $sqlPaso = "UPDATE materiales
                    SET fecha_impreso = CURDATE(), estado_material = 'IMPRESO'
                    WHERE id_seguimiento = $id";
        $conexion->query($sqlPaso);
    } elseif ($paso == "armado") {
        $sqlPaso = "UPDATE materiales
                    SET fecha_armado = CURDATE(), estado_material = 'ARMADO'
                    WHERE id_seguimiento = $id";
        $conexion->query($sqlPaso);
    } elseif ($paso == "entregado") {
        $sqlPaso = "UPDATE materiales
                    SET fecha_entregado_cliente = CURDATE(), estado_material = 'ENTREGADO'
                    WHERE id_seguimiento = $id";
        $conexion->query($sqlPaso);
    }

    header("Location: produccion.php");
    exit();
}

// 2) Etapa elegida en los filtros (vacio = todas)
$etapaFiltro = $_GET["etapa"] ?? "";

// 3) Lista de colegios con su avance de produccion
$sql = "SELECT seguimiento.id_seguimiento,
               colegios.nombre AS colegio,
               CONCAT(practicantes.nombres, ' ', practicantes.apellidos) AS practicante,
               materiales.fecha_entrega,
               materiales.fecha_impreso,
               materiales.fecha_armado,
               materiales.fecha_entregado_cliente
        FROM seguimiento
        INNER JOIN colegios ON seguimiento.id_colegio = colegios.id_colegio
        INNER JOIN practicantes ON seguimiento.id_practicante = practicantes.id
        LEFT JOIN materiales ON seguimiento.id_seguimiento = materiales.id_seguimiento
        ORDER BY colegios.nombre";

$resultado = $conexion->query($sql);

$cEdicion = 0;
$cImpresos = 0;
$cArmados = 0;
$cEntregados = 0;

$colegios = [];
while ($fila = $resultado->fetch_assoc()) {
    if ($fila["fecha_entregado_cliente"] != null) {
        $fila["etapa"] = "entregado";
        $cEntregados = $cEntregados + 1;
    } elseif ($fila["fecha_armado"] != null) {
        $fila["etapa"] = "armado";
        $cArmados = $cArmados + 1;
    } elseif ($fila["fecha_impreso"] != null) {
        $fila["etapa"] = "impreso";
        $cImpresos = $cImpresos + 1;
    } else {
        $fila["etapa"] = "edicion";
        $cEdicion = $cEdicion + 1;
    }

    if ($etapaFiltro == "" || $etapaFiltro == $fila["etapa"]) {
        $colegios[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produccion - ISHUME 2026</title>
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/configuracion.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/menu.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/dashboard.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/tarjetas.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/tablas.css">
    <link rel="stylesheet" href="/monitoreo_ishume_2026/public/css/sistema.css">
</head>
<body>
    <div class="contenedor">
        <?php
        $pagina = "produccion";
        require "menu.php";
        ?>
        <main class="contenido">
            <div class="titulo">
                <h1>Produccion</h1>
                <p>Colegios en edicion, impresos, armados y entregados al cliente</p>
            </div>
            <section class="seccion-dashboard">
                <h2>Resumen</h2>
                <br>
                <div class="tarjetas">
                    <div class="tarjeta">
                        <h3>EN EDICION</h3>
                        <div class="numero"><?php echo $cEdicion; ?></div>
                    </div>
                    <div class="tarjeta">
                        <h3>IMPRESOS</h3>
                        <div class="numero"><?php echo $cImpresos; ?></div>
                    </div>
                    <div class="tarjeta">
                        <h3>ARMADOS</h3>
                        <div class="numero"><?php echo $cArmados; ?></div>
                    </div>
                    <div class="tarjeta">
                        <h3>ENTREGADOS</h3>
                        <div class="numero"><?php echo $cEntregados; ?></div>
                    </div>
                </div>
            </section>
            <section class="seccion-dashboard">
                <div class="encabezado-tabla">
                    <h2>Colegios (<?php echo count($colegios); ?>)</h2>
                </div>
                <div class="filtros">
                    <a href="produccion.php" class="<?php if ($etapaFiltro == '') echo 'activo'; ?>">TODOS</a>
                    <a href="produccion.php?etapa=edicion" class="<?php if ($etapaFiltro == 'edicion') echo 'activo'; ?>">EN EDICION</a>
                    <a href="produccion.php?etapa=impreso" class="<?php if ($etapaFiltro == 'impreso') echo 'activo'; ?>">IMPRESOS</a>
                    <a href="produccion.php?etapa=armado" class="<?php if ($etapaFiltro == 'armado') echo 'activo'; ?>">ARMADOS</a>
                    <a href="produccion.php?etapa=entregado" class="<?php if ($etapaFiltro == 'entregado') echo 'activo'; ?>">ENTREGADOS</a>
                </div>
                <div class="tabla-contenedor">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>COLEGIO</th>
                                <th>PRACTICANTE</th>
                                <th>ETAPA</th>
                                <th>ENTREGA PREVISTA</th>
                                <th>IMPRESO</th>
                                <th>ARMADO</th>
                                <th>ENTREGADO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colegios as $c): ?>
                                <tr>
                                    <td><?php echo $c['colegio']; ?></td>
                                    <td><?php echo $c['practicante']; ?></td>
                                    <td>
                                        <?php if ($c['etapa'] == 'edicion'): ?>
                                            <span class="etiqueta etiqueta-pendiente">EN EDICION</span>
                                        <?php elseif ($c['etapa'] == 'impreso'): ?>
                                            <span class="etiqueta etiqueta-impreso">IMPRESO</span>
                                        <?php elseif ($c['etapa'] == 'armado'): ?>
                                            <span class="etiqueta etiqueta-armado">ARMADO</span>
                                        <?php else: ?>
                                            <span class="etiqueta etiqueta-completado">ENTREGADO</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $c['fecha_entrega'] ?? '-'; ?></td>
                                    <td><?php echo $c['fecha_impreso'] ?? '-'; ?></td>
                                    <td><?php echo $c['fecha_armado'] ?? '-'; ?></td>
                                    <td><?php echo $c['fecha_entregado_cliente'] ?? '-'; ?></td>
                                    <td>
                                        <?php
                                        $paso = "";
                                        $textoBoton = "";
                                        if ($c['etapa'] == 'edicion') {
                                            $paso = "impreso";
                                            $textoBoton = "MARCAR IMPRESO";
                                        } elseif ($c['etapa'] == 'impreso') {
                                            $paso = "armado";
                                            $textoBoton = "MARCAR ARMADO";
                                        } elseif ($c['etapa'] == 'armado') {
                                            $paso = "entregado";
                                            $textoBoton = "MARCAR ENTREGADO";
                                        }
                                        ?>
                                        <?php if ($paso != ""): ?>
                                            <form action="" method="POST" class="form-en-linea">
                                                <input type="hidden" name="id_seguimiento" value="<?php echo $c['id_seguimiento']; ?>">
                                                <input type="hidden" name="paso" value="<?php echo $paso; ?>">
                                                <button type="submit" class="btn-accion"><?php echo $textoBoton; ?></button>
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
