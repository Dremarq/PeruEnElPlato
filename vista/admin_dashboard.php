<?php
session_start();
require_once "../config/conexion.php";



$pedidos_pendientes_query = "SELECT COUNT(*) as total FROM pedidos WHERE estado = 'Pendiente'";
$result = mysqli_query($conexion, $pedidos_pendientes_query);
$pedidos_pendientes = mysqli_fetch_assoc($result)['total'];

$reservas_pendientes_query = "SELECT COUNT(*) as total FROM reservas WHERE estado = 'Pendiente'";
$result = mysqli_query($conexion, $reservas_pendientes_query);
$reservas_pendientes = mysqli_fetch_assoc($result)['total'];

$total_clientes_query = "SELECT COUNT(*) as total FROM usuarios";
$result = mysqli_query($conexion, $total_clientes_query);
$total_clientes = mysqli_fetch_assoc($result)['total'];

// Total de Ventas
$ventas_totales_query = "SELECT SUM(total) as total FROM pedidos WHERE estado = 'Completado'";
$result = mysqli_query($conexion, $ventas_totales_query);
$ventas_totales = mysqli_fetch_assoc($result)['total'] ?? 0; // Si no hay ventas, asignar 0
// Ventas Semanales
$ventas_semanales_query = "SELECT SUM(total) as total FROM pedidos 
WHERE estado = 'Completado' AND fecha_pedido >= NOW() - INTERVAL 7 DAY";
$result = mysqli_query($conexion, $ventas_semanales_query);
$ventas_semanales = mysqli_fetch_assoc($result)['total'] ?? 0; // Si no hay ventas, asignar 0

// Ventas Bimestrales
$ventas_bimestrales_query = "SELECT SUM(total) as total FROM pedidos 
WHERE estado = 'Completado' AND fecha_pedido >= NOW() - INTERVAL 2 MONTH";
$result = mysqli_query($conexion, $ventas_bimestrales_query);
$ventas_bimestrales = mysqli_fetch_assoc($result)['total'] ?? 0; // Si no hay ventas, asignar 0
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../public/JavaScript/dashboard-charts.js"></script>
    <title>Interfaz de Administrador</title>
    <style>
        .dashboard-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        background-color: #ffffff; /* Cambiado a blanco neto */
        margin: 30px 0;
        padding: 20px; /* Espaciado interno para el contenedor */
        border-radius: 5px; /* Bordes redondeados */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }
        .summary-card {
            flex: 1 1 calc(33.333% - 10px);
            margin: 5px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 42px;
            text-align: center;
            font-size: 0.9rem; /* Tamaño de fuente más pequeño */
        }

        .summary-card h5 {
            margin-bottom: 5px;
            font-size: 1rem; /* Tamaño de fuente para el título */
            color: #333;
        }

        .summary-card .card-value {
            font-size: 1.2rem; /* Tamaño de fuente para el valor */
            font-weight: bold;
            color: #28a745; /* Color verde */
        }

        .card {
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 15px; /* Espaciado interno más pequeño */
        }

        canvas {
            max-width: 100%;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px; /* Espaciado más pequeño */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold; /* Negrita para el encabezado */
        }

        tr:hover {
            background-color: #f1f1f1; /* Resaltar fila al pasar el mouse */
        }

        .sidebar {
            width: 200px; /* Ancho más pequeño para el menú lateral */
            background-color: #333;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            position: fixed; /* Fijo para que permanezca en la vista */
            height: 100%; /* Altura completa */
            overflow-y: auto; /* Desplazamiento vertical si es necesario */
        }

        .sidebar h2 {
            font-size: 1.2rem; /* Tamaño de fuente más pequeño */
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background: #575757; /* Color de fondo al pasar el mouse */
        }

        .content {
            margin-left: 220px; /* Espacio para el menú lateral */
            padding: 20px; /* Espaciado interno */
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Pantalla de Administrador</h2>
            <ul>
                <li><a href="#">Dashboard - Perú en el plato</a></li>
                <li><a href="../vista/almacen.php">Almacen</a></li>
                <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
                <li><a href="../vista/empleados.php">Empleados</a></li>
                <li><a href="../vista/pedidos.php">Pedidos</a></li>
                <li><a href="../vista/productos.php">Productos</a></li>
                <li><a href="../vista/platos.php">Platos</a></li>
                <li><a href="../vista/proveedores.php">Proveedores</a></li>
                <li><a href="../vista/reservas.php">Reserva</a></li>
                <li><a href="../vista/roles.php">Roles</a></li>
                <li><a href="../vista/usuario.php">Usuarios</a></li>
            </ul>
        </nav>
        <main class="content">
            <h1>Bienvenido al Panel de Administración</h1>
            <p>Selecciona una opción del menú para comenzar.</p>
            <div><a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a></div>
            <div class="dashboard-container">
                <div class="row">
                <div class="summary-cards">
                <div class="summary-card">
                    <h5>Total de Ventas</h5>
                    <div class="card-value"><?= number_format($ventas_totales, 2) ?> S/</div>
                </div>
                <div class="summary-card">
                    <h5>Ventas Semanales</h5>
                    <div class="card-value"><?= number_format($ventas_semanales, 2) ?> S/</div>
                </div>
                <div class="summary-card">
                    <h5>Ventas Bimestrales</h5>
                    <div class="card-value"><?= number_format($ventas_bimestrales, 2) ?> S/</div>
                </div>
                <div class="summary-card">
                    <h5>Pedidos Pendientes</h5>
                    <div class="card-value"><?= $pedidos_pendientes ?></div>
                </div>
                <div class="summary-card">
                    <h5>Reservas Pendientes</h5>
                    <div class="card-value"><?= $reservas_pendientes ?></div>
                </div>
                <div class="summary-card">
                    <h5>Total de Clientes</h5>
                    <div class="card-value"><?= $total_clientes ?></div>
                </div>
            </div>
<!-- Gráficos -->
<div class="row mt-4" style="display: flex; justify-content: space-between;">
    <div class="col-md-6" style="flex: 1;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ventas Mensuales</h5>
                <canvas id="ventasChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6" style="flex: 1;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tipos de Pedidos</h5>
                <canvas id="pedidosChart"></canvas>
            </div>
        </div>
    </div>
</div>
                

                <!-- Tablas de resumen -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimos Pedidos</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ultimosPedidos = "SELECT p.id_pedido, u.nombre, p.total, p.estado 
                                               FROM pedidos p
                                               JOIN usuarios u ON p.id_usuario = u.id_usuario
                                               ORDER BY p.fecha_pedido DESC
                                               LIMIT 5";
                                        $resultado = mysqli_query($conexion, $ultimosPedidos);
                                        while ($pedido = mysqli_fetch_assoc($resultado)) {
                                            echo "<tr>
                                        <td>{$pedido['id_pedido']}</td>
                                        <td>{$pedido['nombre']}</td>
                                        <td>S/ " . number_format($pedido['total'], 2) . "</td>
                                        <td>{$pedido['estado']}</td>
                                      </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Productos Más Vendidos</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad Vendida</th>
                                            <th>Ingresos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Platos Más Vendidos
                                        $platosMasVendidos = "SELECT 
                                        p.nombre, 
                                        SUM(dp.cantidad) as cantidad_total,
                                        SUM(dp.cantidad * dp.precio_unitario) as ingresos_total
                                        FROM detalle_pedido dp
                                        JOIN platos p ON dp.id_plato = p.id_plato  // Asegúrate de que esto esté correcto
                                        GROUP BY p.id_plato
                                        ORDER BY cantidad_total DESC
                                        LIMIT 5";
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div> <!-- Cierre del container -->

    </main> <!-- Cierre del main -->



</body>

</html>