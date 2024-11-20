<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Pago</title>
    <link rel="stylesheet" href="../../public/styles/pagos.css"> <!-- Vinculación del archivo CSS -->

</head>

<body>

<div class="payment-container">
    <h2>INFORMACIÓN DE PAGO</h2>
    
    <label for="card-name">NOMBRE DE LA TARJETA</label>
    <input type="text" id="card-name" placeholder="Nombre en la tarjeta">

    <label for="card-number">NÚMERO DE TARJETA</label>
    <input type="text" id="card-number" placeholder="**** **** **** 4487">

    <div class="input-group">
        <div>
            <label for="expiry-date">MM/AA</label>
            <input type="text" id="expiry-date" placeholder="MM/AA">
        </div>
        <div>
            <label for="cvc">CVC</label>
            <input type="text" id="cvc" placeholder="***">
        </div>
    </div>

    <button class="pay-button">PAGAR AHORA</button>
</div>

</body>
</html>
