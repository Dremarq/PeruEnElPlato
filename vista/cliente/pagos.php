<?php
session_start();

// Verificar si hay un carrito en la sesión
if (!isset($_SESSION['carrito'])) {
    header("Location: inicio.php"); // Redirigir si no hay carrito
    exit();
}

$carrito = $_SESSION['carrito'];
$total = 0;

// Calcular el total
foreach ($carrito as $plato) {
    $total += $plato['precio'] * $plato['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar</title>
    <link rel="stylesheet" href="../../public/styles/procesar.css">
</head>

<body>
<div class="metodo-pago-box">
    <h2>Formulario de Pago</h2>
    <p>Total a Pagar: s/.<?php echo number_format($total, 2); ?></p>
    <form action="procesar_pago.php" method="POST">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago:</label>
                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                    <option value="">Seleccione un método</option>
                    <option value="yape">Yape</option>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="plin">Plin</option>
                </select>
            </div>
        
        <div class="mb-3" id="info_pago"></div>
        <button type="submit" class="btn btn-primary">Pagar</button>
    </form>
    </div>

    <script>
        document.getElementById('metodo_pago').addEventListener('change', function() {
            const metodo = this.value;
            const infoPago = document.getElementById('info_pago');
            infoPago.innerHTML = ''; // Limpiar campos anteriores

            if (metodo === 'tarjeta') {
                infoPago.innerHTML = `
                    <div class="mb-3">
                        <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                        <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_expiracion" class="form-label">Fecha de Expiración:</label>
                        <input type="month" class="form-control" id="fecha_expiracion" name="fecha_expiracion" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV:</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>
                `;
            } else if (metodo === 'yape' || metodo === 'plin') {
                infoPago.innerHTML = `
                    <div class="mb-3">
                        <label for="numero_celular" class="form-label">Número de Celular:</label>
                        <input type="text" class="form-control" id="numero_celular" name="numero_celular" required>
                    </div>
                `;
            }
        });
    </script>
</body>

</html>