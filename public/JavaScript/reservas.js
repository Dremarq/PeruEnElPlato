function abrirModalModificar(id, idUsuario, numeroMesa, fechaReserva, horaReserva, cantidadPersonas, estado) {
    document.getElementById('modificar_id_reserva').value = id;
    document.getElementById('modificar_id_usuario').value = idUsuario;
    document.getElementById('modificar_numero_mesa').value = numeroMesa;
    document.getElementById('modificar_fecha_reserva').value = fechaReserva;
    document.getElementById('modificar_hora_reserva').value = horaReserva;
    document.getElementById('modificar_cantidad_personas').value = cantidadPersonas;
    document.getElementById('modificar_estado').value = estado;
}

function preventNegativeValue(input) {
    if (input.value < 0) {
        input.value = 0; // Si el valor es menor a 0, se establece en 0
    }
}

// Aplicar la función a los campos de cantidad y precio unitario
const mesa = document.getElementById('numero_mesa');
const mesaModal = document.getElementById('modificar_numero_mesa');

mesa.addEventListener('input', function() {
    preventNegativeValue(this);
});
mesaModal.addEventListener('input', function() {
    preventNegativeValue(this);
});

const personas = document.getElementById('numero_mesa');
const personasModal = document.getElementById('modificar_cantidad_personas');

personas.addEventListener('input', function() {
    preventNegativeValue(this);
});
personasModal.addEventListener('input', function() {
    preventNegativeValue(this);
});