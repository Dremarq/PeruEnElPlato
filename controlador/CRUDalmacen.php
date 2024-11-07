<?php
require_once '../modelo/almacen.php';
require_once '../config/conexion.php';

class AlmacenController
{
    private $modelo;

    public function __construct()
    {
        global $conexion;
        $this->modelo = new Almacen($conexion);
    }

    public function procesarAccion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                switch ($_POST['accion']) {
                    case 'registrar':
                        return $this->registrar();
                    case 'modificar':
                        return $this->modificar();
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
                return $this->eliminar();
            }
        }
    }

    private function registrar()
    {
        $id_producto = $_POST['id_producto'];
        $stock_actual = $_POST['stock_actual'];
        $stock_minimo = $_POST['stock_minimo'];
        $id_almacen = $this->modelo->registrarProductoEnAlmacen($id_producto, $stock_actual, $stock_minimo);
        if ($id_almacen > 0) {
            $_SESSION['mensaje'] = 'Producto registrado en almacén con éxito';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al registrar producto en almacén';
            $_SESSION['tipo_mensaje'] = 'danger';
        }
        header('Location: ../vista/almacen.php');
        exit;
    }

    private function modificar()
    {
        $id_almacen = $_POST['id_almacen'];
        $stock_actual = $_POST['stock_actual'];
        $stock_minimo = $_POST['stock_minimo'];
        $filas_afectadas = $this->modelo->modificarInventario($id_almacen, $stock_actual, $stock_minimo);
        if ($filas_afectadas > 0) {
            $_SESSION['mensaje'] = 'Inventario actualizado con éxito';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar inventario';
            $_SESSION['tipo_mensaje'] = 'danger';
        }
        header('Location: ../vista/almacen.php');
        exit;
    }

    private function eliminar()
    {
        if (isset($_GET['id'])) {
            $id_almacen = $_GET['id'];
            $filas_afectadas = $this->modelo->eliminarProductoDeAlmacen($id_almacen);

            if ($filas_afectadas > 0) {
                $_SESSION['mensaje'] = "Registro eliminado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el registro";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "ID no proporcionado";
            $_SESSION['tipo_mensaje'] = "danger";
        }

        header("Location: ../vista/almacen.php");
        exit();
    }
}


// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia del controlador y procesar la acción
$controller = new AlmacenController();
$controller->procesarAccion();
