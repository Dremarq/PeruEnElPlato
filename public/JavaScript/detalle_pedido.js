function abrirModalModificarDetalle(idDetalle, idPedido, idPlato, cantidad, precioUnitario) {
    // Asignar los valores a los campos del modal
    document.getElementById('id_detalle').value = idDetalle;
    document.getElementById('id_pedido_modificar').value = idPedido;
    document.getElementById('id_plato_modificar').value = idPlato;
    document.getElementById('cantidad_modificar').value = cantidad;
    document.getElementById('precio_unitario_modificar').value = precioUnitario;

    // Mostrar el modal
    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModalDetalle'));
    modificarModal.show();
}
// Función para confirmar eliminación

function preventNegativeValue(input) {
    if (input.value < 0) {
        input.value = 0; // Si el valor es menor a 0, se establece en 0
    }
}

// Aplicar la función a los campos de cantidad y precio unitario
const cantidad = document.getElementById('cantidad');
const precioUnitario = document.getElementById('precio_unitario');

cantidad.addEventListener('input', function() {
    preventNegativeValue(this);
});

precioUnitario.addEventListener('input', function() {
    preventNegativeValue(this);
});
const cantidadModal = document.getElementById('cantidad_modificar');
const precioUnitarioModal = document.getElementById('precio_unitario_modificar');

cantidadModal.addEventListener('input', function() {
    preventNegativeValue(this);
});

precioUnitarioModal.addEventListener('input', function() {
    preventNegativeValue(this);
});
function toggleDarkMode() {
    const body = document.body;
    const header = document.querySelector('header');
    const tables = document.querySelectorAll('table');
    
    // Alternar clase de modo oscuro en el body y el header
    body.classList.toggle('dark-mode');
    header.classList.toggle('dark-mode');

    // Alternar clase de modo oscuro en las tablas
    tables.forEach(table => {
        table.classList.toggle('table-dark');
    });

    // Cambiar el texto del botón
    const toggleButton = document.getElementById('toggle-dark-mode');
    toggleButton.textContent = body.classList.contains('dark-mode') ? 'Modo Claro' : 'Modo Oscuro';
}