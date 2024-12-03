<?php
session_start();
require_once "../config/conexion.php";
require_once "../modelo/plato.php";

$platoModelo = new Plato($conexion);
$platos = $platoModelo->obtenerPlatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/admi.css">
    <link rel="stylesheet" href="../public/styles/tablas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/191a90e971.js" crossorigin="anonymous"></script>
    <title>Interfaz de Administrador - Platos</title>
</head>

<body>
    <!-- Menú lateral -->
    <nav class="sidebar">
        <h2>Pantalla de Administrador</h2>
        <ul>
            <li><a href="../vista/admin_dashboard.php">Dashboard - Perú en el plato</a></li>
            <li><a href="../vista/almacen.php">Almacén</a></li>
            <li><a href="../vista/detalle_pedido.php">Detalle Pedido</a></li>
            <li><a href="../vista/empleados.php">Empleados</a></li>
            <li><a href="../vista/pedidos.php">Pedidos</a></li>
            <li><a href="../vista/productos.php">Productos</a></li>
            <li><a href="">Platos</a></li>
            <li><a href="../vista/proveedores.php">Proveedores</a></li>
            <li><a href="../vista/reservas.php">Reservas</a></li>
            <li><a href="../vista/roles.php">Roles</a></li>
            <li><a href="../vista/usuario.php">Usuarios</a></li>

        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Registro de Platos</h2>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        <?php endif; ?>

        <!-- Opciones de botones -->
        <a href="../controlador/logout.php" class="btn" style="background-color: #e74c3c; color: white;">Cerrar Sesión</a>
        <button type="button" class="btn" style="background-color: #3498db; color: white;" data-bs-toggle="modal" data-bs-target="#registroModal">Registrar</button>
        <button type="button" class="btn" style="background-color: #e67e22; color: white;" onclick="location.href='../controlador/CRUDplato.php?accion=generar_pdf'">Generar PDF</button>
        <button type="button" class="btn" style="background-color: #2ecc71; color: white;" onclick="location.href='../controlador/CRUDplato.php?accion=generar_excel'">Generar Excel</button>

        <!-- Modal de Registro -->
        <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroModalLabel">Registrar Nuevo Plato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDplato.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio:</label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0. 01" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría:</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <option value="Principal">Plato Principal</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Postre">Postre</option>
                                    <option value="Bebida">Refresco</option>
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen:</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado:</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="1">Disponible</option>
                                    <option value="0">No Disponible</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Registrar Plato</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Platos -->
        <h3>Lista de Platos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($plato = $platos->fetch_object()): ?>
                    <tr>
                        <td><?= $plato->id_plato ?></td>
                        <td><?= $plato->nombre ?></td>
                        <td><?= $plato->descripcion ?></td>
                        <td><?= number_format($plato->precio, 2) ?> </td>
                        <td><?= $plato->categoria ?></td>
                        <td><img src="../public/img/<?= $plato->imagen ?>" alt="<?= $plato->nombre ?>" width="100"></td>
                        <td><?= $plato->estado ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="abrirModalModificarPlato(<?= $plato->id_plato ?>, '<?= $plato->nombre ?>', '<?= $plato->descripcion ?>', <?= $plato->precio ?>, '<?= $plato->categoria ?>',  '<?= $plato->imagen ?>','<?= $plato->estado ?>')"><i class="fa-solid fa-pen-to-square"></i></button>
                            <a href="../controlador/CRUDplato.php?accion=eliminar&id=<?= $plato->id_plato ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


        <!-- Modal de Modificación -->
        <div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarModalLabel">Modificar Plato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../controlador/CRUDplato.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="accion" value="modificar">
                            <input type="hidden" id="id_plato" name="id_plato">
                            <div class="mb-3">
                                <label for="nombreModificar" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombreModificar" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcionModificar" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcionModificar" name="descripcion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precioModificar" class="form-label">Precio:</label>
                                <input type="number" class="form-control" id="precioModificar" name="precio" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoriaModificar" class="form-label">Categoría:</label>
                                <select class="form-select" id="categoriaModificar" name="categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <option value="Principal">Plato Principal</option>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Postre">Postre</option>
                                    <option value="Bebida">Refresco</option>
                                </select>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagenModificar" class="form-label">Imagen (opcional):</label>
                                <input type="file" class="form-control" id="imagenModificar" name="imagen" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="estadoModificar" class="form-label">Estado:</label>
                                <select class="form-select" id="estadoModificar" name="estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="1">Disponible</option>
                                    <option value="0">No Disponible</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/JavaScript/plato.js"></script>                
</body>

</html>