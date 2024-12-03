function abrirModalModificar(id, idUsuario, idEmpleado, fechaPedido, estado, tipoPedido, total) {
    // Corregir los IDs de los campos
    document.getElementById('id_pedido').value = id;
    document.getElementById('id_usuario_modificar').value = idUsuario;
    document.getElementById('id_empleado_modificar').value = idEmpleado;
    document.getElementById('fecha_pedido_modificar').value = fechaPedido;
    document.getElementById('estado_modificar').value = estado;
    document.getElementById('tipo_pedido_modificar').value = tipoPedido;
    document.getElementById('total_modificar').value = total;

    // Crear y mostrar el modal correctamente
    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
    modificarModal.show();
}

function eliminarPedido() {
    return confirm("¿Estás seguro de que deseas eliminar este pedido?");
}

function preventNegativeValue(input) {
    if (input.value < 0) {
        input.value = 0; // Si el valor es menor a 0, se establece en 0
    }
}

// Aplicar la función a los campos de cantidad y precio unitario
const total = document.getElementById('total');


total.addEventListener('input', function() {
    preventNegativeValue(this);
});


const totalModal = document.getElementById('total_modificar');


totalModal.addEventListener('input', function() {
    preventNegativeValue(this);
});