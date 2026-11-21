<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISHUME 2026 - Monitoreo de Avances</title>

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
        $pagina = "inicio";
        require "menu.php";
        ?>
        <main class="contenido">
            <div class="titulo">
                <h1>ISHUME 2026</h1>
                <p>Monitoreo de Avances</p>
            </div>
            <section class="seccion-dashboard">
                <h2>Resumen</h2>
                <br>
                <div class="tarjetas">
                    <div class="tarjeta">
                        <h3>PRACTICANTES</h3>
                        <div class="numero">
                            <?php echo $total; ?>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <h3>PENDIENTES</h3>
                        <div class="numero">
                            <?php echo $pendientes; ?>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <h3>EN PROCESO</h3>
                        <div class="numero">
                            <?php echo $proceso; ?>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <h3>COMPLETADOS</h3>
                        <div class="numero">
                            <?php echo $completados; ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="seccion-dashboard">
                <div class="encabezado-tabla">
                    <h2>Practicantes</h2>
                    <a href="/monitoreo_ishume_2026/app/views/agregar_practicante.php"
                        class="btn-agregar">+ AGREGAR PRACTICANTE</a>
                </div>
                <form action="/monitoreo_ishume_2026/" method="GET" class="buscador">
                    <input type="text" name="buscar" placeholder="Buscar por DNI, nombres o apellidos..."
                        value="<?php echo htmlspecialchars($textoBuscado); ?>">
                    <button type="submit" class="btn-accion">BUSCAR</button>
                    <?php if ($textoBuscado != ""): ?>
                        <a href="/monitoreo_ishume_2026/" class="btn-accion btn-accion-claro">LIMPIAR</a>
                    <?php endif; ?>
                </form>
                <div class="tabla-contenedor">
                    <table class="tabla-datos">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>CARRERA</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($practicantes) == 0): ?>
                                <tr>
                                    <td colspan="5">No se encontraron practicantes.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($practicantes as $practicante): ?>
                                <tr>
                                    <td><?php echo $practicante["DNI"]; ?></td>
                                    <td><?php echo $practicante["nombres"]; ?></td>
                                    <td><?php echo $practicante["apellidos"]; ?></td>
                                    <td><?php echo $practicante["carrera"]; ?></td>
                                    <td>
                                        <a href="/monitoreo_ishume_2026/app/views/detalle_practicante.php?id=<?php echo $practicante['id']; ?>" class="btn-accion btn-accion-claro">VER</a>
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