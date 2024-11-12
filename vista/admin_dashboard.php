<?php
session_start();
require_once "../config/conexion.php";

// Consultas para obtener los datos
$ventas_totales_query = "SELECT SUM(total) as total FROM pedidos";
$result = mysqli_query($conexion, $ventas_totales_query);
$ventas_totales = mysqli_fetch_assoc($result)['total'];

$pedidos_pendientes_query = "SELECT COUNT(*) as total FROM pedidos WHERE estado = 'Pendiente'";
$result = mysqli_query($conexion, $pedidos_pendientes_query);
$pedidos_pendientes = mysqli_fetch_assoc($result)['total'];

$reservas_pendientes_query = "SELECT COUNT(*) as total FROM reservas WHERE estado = 'Pendiente'";
$result = mysqli_query($conexion, $reservas_pendientes_query);
$reservas_pendientes = mysqli_fetch_assoc($result)['total'];

$total_clientes_query = "SELECT COUNT(*) as total FROM usuarios";
$result = mysqli_query($conexion, $total_clientes_query);
$total_clientes = mysqli_fetch_assoc($result)['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../public/JavaScript/dashboard-charts.js"></script>

    <title>Interfaz de Administrador</title>

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
                <li><a href="../vista/proveedores.php">Proveedores</a></li>
                <li><a href="../vista/reservas.php">Reserva</a></li>
                <li><a href="../vista/roles.php">Roles</a></li>
                <li><a href="../vista/usuario.php">Usuarios</a></li>
            </ul>
        </nav>
        <main class="content">
            <h1>Bienvenido al Panel de Administración</h1>
            <p>Selecciona una opción del menú para comenzar.</p>
            <div><a href="../controlador/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón de cierre de sesión --></div>
            <div class="dashboard-container">
                <div class="row">
                    <!-- Tarjetas de resumen -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ventas Totales</h5>
                                <p class="card-text">S/ <?= number_format($ventas_totales, 2) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pedidos Pendientes</h5>
                                <p class="card-text"><?= $pedidos_pendientes ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reservas Pendientes</h5>
                                <p class="card-text"><?= $reservas_pendientes ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Clientes</h5>
                                <p class="card-text"><?= $total_clientes ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ventas Mensuales</h5>
                                <canvas id="ventasChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
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
                                        $productosMasVendidos = "SELECT 
                                p.nombre, 
                                SUM(dp.cantidad) as cantidad_total,
                                SUM(dp.cantidad * dp.precio_unitario) as ingresos_total
                                FROM detalle_pedido dp
                                JOIN productos p ON dp.id_producto = p.id_producto
                                GROUP BY p.id_producto
                                ORDER BY cantidad_total DESC
                                LIMIT 5";
                                        $resultado = mysqli_query($conexion, $productosMasVendidos);
                                        while ($producto = mysqli_fetch_assoc($resultado)) {
                                            echo "<tr>
                                        <td>{$producto['nombre']}</td>
                                        <td>{$producto['cantidad_total']}</td>
                                        <td>S/ " . number_format($producto['ingresos_total'], 2) . "</td>
                                      </tr>";
                                        }
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