function abrirModalModificarPlato(id, nombre, descripcion, precio, categoria, imagen, estado) {
    document.getElementById('id_plato').value = id;
    document.getElementById('nombreModificar').value = nombre;
    document.getElementById('descripcionModificar').value = descripcion;
    document.getElementById('precioModificar').value = precio;
    document.getElementById('categoriaModificar').value = categoria;
    document.getElementById('estadoModificar').value = estado; // Asegúrate de que el valor se pasa correctamente.

    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
    modificarModal.show();
}
function preventNegativeValue(input) {
    if (input.value < 0) {
        input.value = 0; // Si el valor es menor a 0, se establece en 0
    }
}

// Aplicar la función a los campos de cantidad y precio unitario
const precio = document.getElementById('precio');


precio.addEventListener('input', function() {
    preventNegativeValue(this);
});


const precioModal = document.getElementById('precioModificar');


precioModal.addEventListener('input', function() {
    preventNegativeValue(this);
});