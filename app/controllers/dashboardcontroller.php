<?php
class DashboardController
{
    public function index()
    {
        require_once "config/conexion.php";

        // Lista de practicantes
        $sql = "SELECT id, DNI, nombres, apellidos, telefono, carrera
                FROM practicantes
                ORDER BY id ASC";

        $resultado = $conexion->query($sql);

        $practicantes = [];

        while ($fila = $resultado->fetch_assoc()) {
            $practicantes[] = $fila;
        }

        // Total de practicantes
        $sqlTotal = "SELECT COUNT(*) AS total FROM practicantes";
        $resultadoTotal = $conexion->query($sqlTotal);
        $filaTotal = $resultadoTotal->fetch_assoc();
        $total = $filaTotal["total"];

        // Colegios pendientes
        $sqlPendientes = "SELECT COUNT(*) AS pendientes
                          FROM seguimiento
                          WHERE estado = 'PENDIENTE'";
        $resultadoPendientes = $conexion->query($sqlPendientes);
        $filaPendientes = $resultadoPendientes->fetch_assoc();
        $pendientes = $filaPendientes["pendientes"];

        // Colegios en proceso
        $sqlProceso = "SELECT COUNT(*) AS proceso
                       FROM seguimiento
                       WHERE estado = 'EN PROCESO'";
        $resultadoProceso = $conexion->query($sqlProceso);
        $filaProceso = $resultadoProceso->fetch_assoc();
        $proceso = $filaProceso["proceso"];

        // Colegios completados
        $sqlCompletados = "SELECT COUNT(*) AS completados
                           FROM seguimiento
                           WHERE estado = 'COMPLETADO'";
        $resultadoCompletados = $conexion->query($sqlCompletados);
        $filaCompletados = $resultadoCompletados->fetch_assoc();
        $completados = $filaCompletados["completados"];

        require_once "app/views/dashboard.php";
    }
}
?>
